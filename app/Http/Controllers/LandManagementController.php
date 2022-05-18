<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dimension;
use App\Models\Area;
use App\Models\Claim;
use App\Models\ClaimType;
use Illuminate\Support\Facades\Auth;

class LandManagementController extends Controller
{
    public function add($type, Request $request){
        $submittedToken = $request->post('_token');
        $sessionToken = $request->session()->get('_token');
        if ($submittedToken != $sessionToken){
          abort(418);
        }
        switch($type){
            case 'dimension':
                Dimension::create([
                    'name' => str_replace(' ', '_', strtolower($request->post('dimension-name'))),
                    'boundary' => trim(json_encode($request->post('coords'))),
                    'created_by' => Auth::id(),
                    'modified_by' => null
                ]);
                break;
            case 'area':

                break;
            case 'claim_type':
                
                ClaimType::create([
                    'name' => $request->post('claim_type-name'),
                    'icon' => $request->post('icon-path'),
                    'measured_by' => $request->post('measured_by'),
                    'size' => $request->post('size'),
                    'shareable' => $request->post('shareable'),
                    'shared_measured_by' => $request->post('shared_measured_by'),
                    'shared_size' => $request->post('shared_size'),
                    'prompt_id' => $request->post('prompt_id'),
                    'dimension' => $request->post('dimension'),
                    'area_allowed' => $request->post('area_allowed'),
                    'amount_allowed' => $request->post('amount_allowed'),
                    'review_requires_team' => $request->post('requires_team'),
                    'buffer' => $request->post('buffer'),
                    'expire_time' => $request->post('expire_time')
                ]);
                break;
            case 'claim':
                Claim::create([
                    'type' => 0,
                    'status' => 4,
                    'nickname' => $request->post('claim-name'),
                    'boundary' => trim(json_encode($request->post('coords'))),
                    'requested_by' => Auth::id(),
                    'shared' => 0
                ]);
                break;
            default:
                abort(418);
        }
        return redirect('/module/land_management');
        
    }

    public function editLand($type, Request $request){

    }
}
