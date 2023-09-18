<?php

namespace App\Models\PMS\PCR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsPcrStrategicFunctionData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pms_period_id',
        'sys_employee_id',
        'function_title',
        'success_indicator',
        'actual_accomplishment',
        'final_numerical_rating',
        'percent',
        'not_applicable',
    ];
}
