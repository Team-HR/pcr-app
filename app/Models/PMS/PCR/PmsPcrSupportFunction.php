<?php

namespace App\Models\PMS\PCR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsPcrSupportFunction extends Model
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
    ];
}
