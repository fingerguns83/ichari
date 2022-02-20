<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimType extends Model
{
    use HasFactory;
    protected $table = 'claim_types';
    protected $fillable = [
        'id',
        'name',
        'icon',
        'measured_by',
        'size',
        'altername_measured_by',
        'alternate_size',
        'shareable',
        'prompt_id',
        'dimension',
        'area_allowed',
        'amount_allowed',
        'review_requires_team',
        'buffer',
        'expire_time'
    ];
}
