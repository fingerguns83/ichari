<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function claimRequest(Request $request){
        /*Claim::create([
            ''
        ])*/
        $submittedToken = $request->post('_token');
        $sessionToken = $request->session()->get('_token');
        if ($submittedToken == $sessionToken){
            print_r($request->post());
        }
        
    }
}
