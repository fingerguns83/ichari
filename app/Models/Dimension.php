<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'boundary',
        'created_by',
        'modified_by'
    ];
    public function getLocationString(){
        $coords = json_decode($this->boundary, true);
        $output = $coords['x1'] . ', ' . $coords['z1'] . ' to ' . $coords['x2'] . ', ' . $coords['z2'];
        return $output;
    }
}
