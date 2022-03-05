<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModelFetchController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Claim;
use App\Models\Area;
use App\Models\ClaimType;
use App\Notifications\ClaimStatusChanged;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
Route::get('/fetch_model', ModelFetchController::class);
Route::get('/claims/fetch_pending', function(Request $request){

  /* Create functions */
    /**
   * compareBounds
   *
   * @param  array $new
   * @param  array $existing
   * @param  string $mode
   * @param  integer $buffer
   * @return void
   */
  function compareBounds($new, $existing, $mode = "contain", $buffer = 0){
    if ($mode == "contain"){
      if ($new['x1'] < $existing['x1'] - $buffer || $new['z1'] < $existing['z1'] - $buffer){
        return false;
      }
      elseif ($new['x2'] > $existing['x2'] + $buffer || $new['z2'] > $existing['z2'] + $buffer){
        return false;
      }
      else {
        return true;
      }
    }
    elseif ($mode == "collide"){
      if ($new['x1'] > $existing['x2'] + $buffer || $new['x2'] < $existing['x1'] - $buffer){
        return false;
      }
      elseif ($new['z1'] > $existing['z2'] + $buffer || $new['z2'] < $existing['z1'] - $buffer){
        return false;
      }
      else {
        return true;
      }
    }
    else {
      return null;
    }
  }


  /* Fetch Oldest Pending Claim */
  $claim = Claim::where('type', '=', intval($request->query('type')))->where('status', '=', 1)->oldest()->first();
  if (!$claim){
    return null;
  }
  $claimBoundary = json_decode($claim->boundary, true);
  $ownerIds = DB::table('claim_has_users')
    ->select('user_id')
    ->where('claim_id', '=', $claim->id)
    ->get();

  foreach($ownerIds as $owner){
    $owners[] = User::where('id', $owner->user_id)->first();
  }

  $output = array(
    'id' => $claim->id,
    'location' => [
      'x1' => $claimBoundary['x1'],
      'z1' => $claimBoundary['z1'],
      'x2' => $claimBoundary['x2'],
      'z2' => $claimBoundary['z2'],
    ],
    'shared' => $claim->shared,
    'requested_by' => ['id' => $owners[0]->id, 'name' => $owners[0]->username]
  );
  array_shift($owners);
  if ($claim->shared){
    foreach($owners as $owner){
      $output['coowners'][] = ['id' => $owner->id, 'name' => $owner->username, 'avatar' => $owner->avatar];
    }
  }

  /* Analyze Claim Compliance */
  $analysis = "";

  $type = ClaimType::where('id', '=', $claim->type)->first();

  // Area Check
  if ($type->area_allowed){
    $area = Area::where('id', '=', $type->area_allowed)->first();
    $areaBounds = json_decode($area->boundaries, true);
    foreach ($areaBounds as $boundary){
      if ($claimBoundary['x1'] < $boundary['x1'] || $claimBoundary['z1'] < $boundary['z1']){
        $inArea = false;
      }
      elseif ($claimBoundary['x2'] > $boundary['x2'] || $claimBoundary['z2'] > $boundary['z2']){
        $inArea = false;
      }
      else {
        $inArea = true;
        break;
      }
    }
  }
  else {
    $dimension = DB::table('dimensions')
      ->where('id', '=', $type->dimension)
      ->first();
    $dimensionBounds = json_decode($dimension->boundary, true);

    $inArea = compareBounds($claimBoundary, $dimensionBounds);

  }
   
  if (!$inArea){
    $analysis = "Outside Area";
  }

  // Administrative Collision Check
  if(!$analysis){
    $existingClaims = DB::table('claims')
      ->where('type', 0)
      ->get();
    
    foreach($existingClaims as $existing){
      $existingBoundary = json_decode($existing->boundary, true);
      $collision = compareBounds($claimBoundary, $existingBoundary, "collide", $type->buffer);
      if ($collision){
        $analysis = "Admin Collision";
        break;
      }
    }
  }

  // Claim Collision Check
  if(!$analysis){
    $existingClaims = DB::table('claims')
      ->where('type', $claim->type)
      ->where('status', '>=', 4)
      ->get();
    
    foreach($existingClaims as $existing){
      $existingBoundary = json_decode($existing->boundary, true);
      $collision = compareBounds($claimBoundary, $existingBoundary, "collide", $type->buffer);
      if ($collision){
        $analysis = "Claim Collision";
        break;
      }
    }
  }

  // Area Collision Check
  if(!$analysis){
    $areas = DB::table('areas')
      ->where('dimension', '=', $type->dimension)
      ->get();
    
    foreach($areas as $area){
      if (!$area->boundaries){
        $collision = false;
      }
      else{
        $areaBounds = json_decode($area->boundaries, true);
        foreach($areaBounds as $areaBoundary){
          $collision = compareBounds($claimBoundary, $areaBoundary, "collide", $type->buffer);
          if ($collision){
            break;
          }
        }
      }
      if ($collision){
        $analysis = "Area Collision";
        break;
      }
    }
  }

  // Holdings Check
  if(!$analysis){
    foreach($ownerIds as $owner){
      $player = User::where('id', $owner->user_id)->first();
      $playerClaimIds = DB::table('claim_has_users')
        ->select('claim_id')
        ->where('user_id', '=', $player->id)
        ->get();
      foreach ($playerClaimIds as $idObj){
        $playerClaims[] = $idObj->claim_id;
      }
      $claimCount = DB::table('claims')
        ->whereIn('id', $playerClaims)
        ->where('type', '=', $claim->type)
        ->where('status', '>=', 4)
        ->count();

      if ($claimCount >= $type->amount_allowed){
        $analysis = "Count - " . $player->username;
      }
    }
  }

  $output['analysis'] = $analysis;

  return trim(json_encode($output));
});

Route::get('/claims/modify/{intent}', function(Request $request, $intent){
  if ($intent == 'review'){
    $claim = Claim::where('id', '=', $request->query('id'))->first();
    
    $expires_on = null;
    if ($request->query('status') == 4){
      $type = ClaimType::where('id', '=', $claim->type)->first();

      if ($type->expire_time){
        $expires_on = date('Y-m-d H:i:s', time() + $type->expire_time);
      }
    }
    if ($claim->status == 1){
      $claim->status = $request->query('status');
      $claim->reviewed_by = $request->query('reviewer');
      $claim->expires_on = $expires_on;
      $claim->save();

      $ownerIds = DB::table('claim_has_users')
      ->where('claim_id', '=', $claim->id)
      ->get();
      foreach($ownerIds as $owner){
        $user = User::where('id', '=', $owner->user_id)->first();
        $user->notify(new ClaimStatusChanged($claim, $user));
      }
    }
  }
});
Route::get('/users/modify', function(Request $request){
  $modifiable = ['timezone', 'perm_level', 'is_admin', 'is_banned'];


  if ($request->query('key') == null || $request->query('value') == null || $request->query('user_id') == null){
    abort(400);
  }
  if (!in_array($request->query('key'), $modifiable)){
    abort(403);
  }
  DB::table('users')
    ->where('id', '=', $request->query('user_id'))
    ->update([$request->query('key') => urldecode($request->query('value'))]);
});
