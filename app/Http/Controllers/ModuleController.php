<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ModuleController extends BaseController
{
  public function loadModule($module){
    if (Auth::check()){
      if (!isset($module)){
        $module = 'dashboard';
      }
      return view('app', ['name' => $module]);
    }
    else {
      abort(403);
    }
  }
}
