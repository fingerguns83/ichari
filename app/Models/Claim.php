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
        'boundary',
        'requested_by',
        'shared',
        'expires_on'
    ];
    public function getLocationString(){
        $coords = json_decode($this->boundary, true);
        $output = $coords['x1'] . ', ' . $coords['z1'] . ' to ' . $coords['x2'] . ', ' . $coords['z2'];
        return $output;
    }
    public function getStatusString(){
        $status = DB::table('claim_statuses')->where('id', '=', $this->status)->first();
        return $status->name;
    }
}
