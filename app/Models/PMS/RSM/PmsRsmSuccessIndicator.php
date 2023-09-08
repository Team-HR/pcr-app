<?php

namespace App\Models\PMS\RSM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsRsmSuccessIndicator extends Model
{
    use HasFactory;


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quality' => 'array',
        'efficiency' => 'array',
        'timeliness' => 'array',
        'in_charges' => 'array',
        'corrections' => 'array'
    ];
}
