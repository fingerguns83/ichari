<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Claim;

class EvaluateClaimStatus extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'claims:evaluate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check claims for expiry';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $claims = DB::table('claims')->get();
    foreach ($claims as $claim){
      $expires_on = strtotime($claim->expires_on);
      if (time() >= $expires_on){
        $status = 3;
      }
      elseif (time() + 604800 >= $expires_on){
        $status = 5;
      }
      else {
        echo "not here";
      }
    }
  }
}
