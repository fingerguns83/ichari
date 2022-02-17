<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'status',
        'northwest_x',
        'northwest_z',
        'southeast_x',
        'southeast_z',
        'requested_by',
        'shared',
        'expires_on'
    ];
    public function getLocationString(){
        $output = $this->northwest_x . ', ' . $this->northwest_z . ' to ' . $this->southeast_x . ', ' . $this->southeast_z;
        return $output;
    }
    public function getStatusString(){
        $status = DB::table('claim_statuses')->where('id', '=', $this->status)->first();
        return $status->name;
    }
}
