<?php

namespace App\Models\PMS\PCR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsPcrCoreFunctionDataHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    protected $casts = [
        'changes' => 'array',
    ];
}
