<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModelFetchController;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
  /* Fetch Oldest Pending Claim */
  $claim = DB::table('claims')
    ->where('type', '=', intval($request->query('type')))
    ->where('status', '=', 1)
    ->oldest()
    ->first();
  if (!$claim){
    return null;
  }
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
      'x1' => $claim->northwest_x,
      'z1' => $claim->northwest_z,
      'x2' => $claim->southeast_x,
      'z2' => $claim->southeast_z,
    ],
    'shared' => $claim->shared,
    'requested_by' => ['id' => $owners[0]->id, 'name' => $owners[0]->discord_name]
  );
  array_shift($owners);
  if ($claim->shared){
    foreach($owners as $owner){
      $output['coowners'][] = ['id' => $owner->id, 'name' => $owner->discord_name, 'avatar' => $owner->discord_avatar];
    }
  }

  /* Analyze Claim Compliance */
  $analysis = "";

  $type = DB::table('claim_types')
  ->select('area_allowed', 'amount_allowed', 'buffer')
  ->where('id', '=', $claim->type)
  ->first();

  // Area Check
  $areasAllowed = json_decode($type->area_allowed, true);

  foreach($areasAllowed as $area){
    if ($claim->northwest_x < $area['x1'] || $claim->northwest_z < $area['z1']){
      $inArea = false;
    }
    elseif ($claim->southeast_x > $area['x2'] || $claim->southeast_z > $area['z2']){
      $inArea = false;
    }
    else {
      $inArea = true;
      break;
    }
  }
  if (!$inArea){
    $analysis = "Outside Approved Area";
  }

  // Collision Check
  if(!$analysis){
    $existingClaims = DB::table('claims')
      ->where('type', '=', $claim->type)
      ->where('status', '>=', 4)
      ->get();
    
    foreach($existingClaims as $existing){
      if ($claim->northwest_x > $existing->southeast_x + $type->buffer || $claim->southeast_x < $existing->northwest_x - $type->buffer){
        $collision = false;
      }
      elseif ($claim->northwest_z > $existing->southeast_z + $type->buffer || $claim->southeast_z < $existing->northwest_z - $type->buffer){
        $collision = false;
      }
      else {
        $collision = true;
      }

      if ($collision){
        $analysis = "Collision";
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
        $analysis = "Count - " . $player->discord_name;
      }
    }
  }

  $output['analysis'] = $analysis;

  return trim(json_encode($output));
});
Route::get('/claims/modify', function(Request $request){
  $claim = DB::table('claims')
    ->select('status')
    ->where('id', '=', $request->query('id'))
    ->first();
  if ($claim->status == 1){
    DB::table('claims')
      ->where('id', '=', $request->query('id'))
      ->update(['status' => $request->query('status'), 'reviewed_by' => $request->query('reviewer')]);
  }
});
