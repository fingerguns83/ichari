<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
  public function show($feature){
    if (!isset($feature)){
      $feature = 'dashboard';
    }
    return view('dashboard', ['show' => $feature]); 
  }
}
