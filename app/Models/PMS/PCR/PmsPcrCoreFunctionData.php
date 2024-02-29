<?php

namespace App\Models\PMS\PCR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsPcrCoreFunctionData extends Model
{
    use HasFactory;

    protected $appends = [
        'histories'
    ];

    // protected $casts = [
    //     'changes' => array
    // ];

    public function getHistoriesAttribute()
    {
        $data = PmsPcrCoreFunctionDataHistory::where('pms_pcr_core_function_data_id', $this->id)->orderByDesc('id')->get();

        return $data;
    }
}
