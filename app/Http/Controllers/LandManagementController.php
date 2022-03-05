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

                break;
            case 'claim':

                break;
            default:
                abort(418);
        }
        return redirect('/module/land_management');
        
    }

    public function editLand($type, Request $request){

    }
}
