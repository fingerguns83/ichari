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
Route::get('/fetch_pending_claims', function(Request $request){
  /* Fetch Oldest Pending Claim */
  $claim = DB::table('claims')
    ->where('type', '=', intval($request->query('type')))
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
      $output['coowners'][] = ['id' => $owner->id, 'name' => $owner->discord_name];
    }
  }

  /* Analyze Claim Compliance */
  // Area Check
  $type = DB::table('claim_types')
    ->select('area_allowed', 'amount_allowed')
    ->where('id', '=', $claim->type)
    ->first();
  $areasAllowed = json_decode($type->area_allowed, true);

  foreach($areasAllowed as $area){
    if ($claim->northwest_x < $area['x1'] || $claim->northwest_z < $area['z1']){
      $areaCheck = false;
    }
    elseif ($claim->southwest_x > $area['x2'] || $claim->southwest_z > $area['z2']){
      $areaCheck = false;
    }
    else {
      $areaCheck = true;
      break;
    }
  }
  // Collision Check
  $existingClaims = DB::table('claims')
    ->where('type', '=', $claim->type)
    ->where('status', '>=', 3)
    ->get();
  
  foreach($existingClaims as $existing){
    if ($)
  }
  //return trim(json_encode($output));
});
