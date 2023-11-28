<?php

namespace App\Models\PMS\PCR;

use App\Models\PMS\PmsPeriod;
use App\Models\SysDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;
use App\Models\SysEmployee;
use App\Models\SysPositions;

class PmsPcrStatus extends Model
{
    use HasFactory;

    protected $casts = [
        'is_submitted' => 'boolean',
    ];

    protected $appends = [
        'signatories_inputs',
        'sys_employee',
        'sys_department',
        'position',
        'period',
        'overall_adjectival_rating'
    ];

    public function getOverallAdjectivalRatingAttribute()
    {
        $adjectival = "";
        if (!$this->overall_numerical_rating) {
            return null;
        }
        $overallAv = $this->overall_numerical_rating;
        if ($overallAv <= 5 && $overallAv > 4) {
            $adjectival = "OUTSTANDING";
        } elseif ($overallAv <= 4 && $overallAv > 3) {
            $adjectival = "Very Satisfactory";
        } elseif ($overallAv <= 3 && $overallAv > 2) {
            $adjectival = "Satisfactory";
        } elseif ($overallAv <= 2 && $overallAv > 1) {
            $adjectival = "Unsatisfactory";
        }

        return $adjectival;
    }

    public function getPositionAttribute()
    {
        if (!$this->sys_position_id) {
            return [
                "position_title" => "____________________________"
            ];
        }
        $sys_position = SysPositions::find($this->sys_position_id);
        return [
            "position_title" => $sys_position->position . " (" . $sys_position->functional . ")"
        ];
    }

    public function getPeriodAttribute()
    {
        $period = PmsPeriod::find($this->pms_period_id);
        return $period;
    }

    public function getSysDepartmentAttribute()
    {
        $department = SysDepartment::find($this->sys_department_id);
        return $department;
    }


    /**
     * Get the employees's full name.
     *
     * @return string
     */

    public function getSysEmployeeAttribute()
    {
        $sys_employee = SysEmployee::find($this->sys_employee_id);
        return $sys_employee;
    }

    public function getSignatoriesInputsAttribute()
    {

        $immediate_supervisor = NULL;

        if (isset($this->immediate_supervisor)) {
            $immediate_supervisor = $this->agency == "lgu" ? SysEmployee::find($this->immediate_supervisor) : $this->immediate_supervisor;
        }

        $department_head = NULL;
        if (isset($this->department_head)) {
            $department_head = $this->agency == "lgu" ? SysEmployee::find($this->department_head) : $this->department_head;
        }

        $array = [
            "immediate_supervisor" => $immediate_supervisor,
            "department_head" => $department_head,
            "head_of_agency" => $this->head_of_agency
        ];


        return $array;
    }
}
