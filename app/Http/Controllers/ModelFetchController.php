<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelFetchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        switch($request->query('table')){
            case 'claim_types':
                $model = DB::table('claim_types')
                    ->where('id', '=', intval($request->query('id')))
                    ->first();
                echo trim(json_encode($model));
                break;
            default:
                abort(418);
                break;
        }
       
    }
}
