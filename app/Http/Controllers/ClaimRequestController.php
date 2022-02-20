<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Claim;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClaimStatusChanged;

class ClaimRequestController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request){
    $submittedToken = $request->post('_token');
    $sessionToken = $request->session()->get('_token');
    if ($submittedToken != $sessionToken){
      abort(418);
    }

    $newClaim = Claim::create([
        'type' => $request->post('type'),
        'status' => 1,
        'northwest_x' => $request->post('coords')['x1'],
        'northwest_z'=> $request->post('coords')['z1'],
        'southeast_x'=> $request->post('coords')['x2'],
        'southeast_z'=> $request->post('coords')['z2'],
        'requested_by' => Auth::id(),
        'shared' => boolval($request->post('shared'))
      ]);
    $claimId = $newClaim->id;
    DB::table('claim_has_users')
      ->insert([
        'claim_id' => $claimId,
        'user_id' => Auth::id()
      ]);

    if ($request->post('shared')){
      foreach($request->post('coowners') as $name){
        $user = User::where('username', '=', $name)->first();
        DB::table('claim_has_users')
          ->insert([
            'claim_id' => $claimId,
            'user_id' => $user->id
          ]);
        $user->notify(new ClaimStatusChanged($newClaim, $user));
      }
    }

    return redirect('/module/claims');
  }
}
