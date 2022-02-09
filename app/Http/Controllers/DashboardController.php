<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
  public function show($feature){
    if (Auth::check()){
      if (!isset($feature)){
        $feature = 'dashboard';
      }
      return view('dashboard', ['show' => $feature]);
    }
    else {
      abort(403);
    }
  }
}
