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
        'location',
        'created_at',
        'created_by',
        'updated_at',
        'modified_by'
    ];


}
