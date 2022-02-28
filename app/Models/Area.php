<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'dimension',
        'boundaries',
        'created_at',
        'created_by',
        'updated_at',
        'modified_by'
    ];

    function getLocationString($opener = '', $closer = '', $implode = false, $separator = ''){
        $boundariesArr = json_decode($this->boundaries, true);
        $output = [];
        foreach((array) $boundariesArr as $boundary){
            $string = $opener . $boundary['x1'] . ', ' . $boundary['z1'] . ' to ' . $boundary['x2'] . ', ' . $boundary['z2'] . $closer;
            $output[] = $string;
        }
        if ($implode){
            $output = implode($separator, $output);
        }
        return $output;
    }
}
