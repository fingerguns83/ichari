<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'shared'
    ];
}
