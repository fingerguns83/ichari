<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request){
        echo Auth::id();
        $submittedToken = $request->post('_token');
        $sessionToken = $request->session()->get('_token');
        if ($submittedToken == $sessionToken){
            print_r($request->post());
        }
        
    }
}
