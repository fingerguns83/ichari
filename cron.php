<?php
require __DIR__.'/vendor/autoload.php';
use Illuminate\Support\Facades\DB;
use App\Models\Claim;

// Claim expiring check
  $claims = DB::table('claims')->get();
  foreach ($claims as $claim){
    $expires_on = strtotime($claim->expires_on);
    if ($expires_on >= time()){
      echo "here";
    }
    else {
      echo "not here";
    }
  }

// Claim abandoned check

