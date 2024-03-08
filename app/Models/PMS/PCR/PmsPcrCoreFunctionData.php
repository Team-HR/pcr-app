<?php

namespace App\Models\PMS\PCR;

use App\Models\SysEmployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsPcrCoreFunctionData extends Model
{
    use HasFactory;

    protected $appends = [
        'histories',
        'correction_comments_data'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    protected $casts = [
        'changes' => 'array',
    ];

    public function getCorrectionCommentsDataAttribute()
    {
        $data = PmsPcrCoreFunctionDataCorrectionComment::where('pms_pcr_core_function_data_id', $this->id)->orderByDesc('id')->get();
        if ($data) {
            foreach ($data as $key => $value) {
                $data[$key]['created_by'] = SysEmployee::find($value['created_by_sys_employee_id'])->full_name;
            }
            // SysEmployee::id($data['created_by_sys_employee_id']);
        }
        return $data;
    }

    public function getHistoriesAttribute()
    {
        $data = PmsPcrCoreFunctionDataHistory::where('pms_pcr_core_function_data_id', $this->id)->orderByDesc('id')->get();

        return $data;
    }
}
