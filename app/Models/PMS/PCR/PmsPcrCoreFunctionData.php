<?php

namespace App\Models\PMS\PCR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsPcrCoreFunctionData extends Model
{
    use HasFactory;

    protected $appends = [
        'corrections'
    ];

    public function getCorrectionsAttribute()
    {
        $data = PmsPcrCoreFunctionDataCorrection::where('pms_pcr_core_function_data_id', $this->id)->orderByDesc('id')->get();

        return $data;
    }
}
