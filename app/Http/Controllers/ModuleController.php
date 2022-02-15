<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModuleController extends BaseController
{
  public function loadModule($module){
    if (Auth::check()){
      if (Auth::user()->is_banned){
        abort(403);
      }
      if (!isset($module)){
        $module = 'dashboard';
      }
      $targetModule = DB::table('modules')
        ->select('requires_perm')
        ->where('name', '=', $module)
        ->first();
        
      if ($targetModule->requires_perm > Auth::user()->perm_level){
        if (!Auth::user()->is_admin){
          abort(403);
        }
      }
      return view('app', ['name' => $module]);
    }
    else {
      abort(403);
    }
  }
}
