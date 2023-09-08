<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PMS\PCR\PmsPcrStatus;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'roles' => 'array'
    ];

    protected $appends = [
        'full_name',
        'last_name',
        'first_name',
        'middle_name',
        'ext',
        'sys_employee_assigned_department_id',
        'sys_department_id',
        'sys_department_name',
        'is_supervisor'
    ];

    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    public function getIsSupervisorAttribute()
    {
        if ($sys_employee_id = $this->sys_employee_id) {
            $status = PmsPcrStatus::where(
                'immediate_supervisor',
                $sys_employee_id
            )->first();
            return $status ? true : false;
        } else return false;
    }

    public function getFullNameAttribute()
    {
        $sys_employee = SysEmployee::find($this->sys_employee_id);
        if (!$sys_employee) {
            return null;
        }
        $last_name = $sys_employee->last_name;
        $first_name = $sys_employee->first_name;
        $middle_name = $sys_employee->middle_name && strlen($sys_employee->middle_name) > 0 ? " " . $sys_employee->middle_name[0] . "." : "";
        $ext = $sys_employee->ext && strlen($sys_employee->ext) > 0 ? " " . $sys_employee->ext : "";

        return "{$last_name}, {$first_name}{$middle_name}{$ext}";
    }

    public function getLastNameAttribute()
    {
        $sys_employee = SysEmployee::find($this->sys_employee_id);
        if (!$sys_employee) {
            return null;
        }
        return $sys_employee->last_name;
    }

    public function getFirstNameAttribute()
    {
        $sys_employee = SysEmployee::find($this->sys_employee_id);
        if (!$sys_employee) {
            return null;
        }
        return $sys_employee->first_name;
    }

    public function getMiddleNameAttribute()
    {
        $sys_employee = SysEmployee::find($this->sys_employee_id);
        if (!$sys_employee) {
            return null;
        }
        return $sys_employee->middle_name;
    }

    public function getExtAttribute()
    {
        $sys_employee = SysEmployee::find($this->sys_employee_id);
        if (!$sys_employee) {
            return null;
        }
        return $sys_employee->ext;
    }

    // sys_employee_assigned_department_id
    public function getSysEmployeeAssignedDepartmentIdAttribute()
    {
        $sys_employee_assigned_department = SysEmployeeAssignedDepartment::where('sys_employee_id', $this->sys_employee_id)
            ->where('is_current', 1)->get()->first();
        if (!$sys_employee_assigned_department) {
            return null;
        }

        return $sys_employee_assigned_department->id;
    }

    public function getSysDepartmentIdAttribute()
    {
        $sys_employee_assigned_department = SysEmployeeAssignedDepartment::where('sys_employee_id', $this->sys_employee_id)
            ->where('is_current', 1)->get('sys_department_id')->first();
        if (!$sys_employee_assigned_department) {
            return null;
        }
        return $sys_employee_assigned_department->sys_department_id;
    }

    public function getSysDepartmentNameAttribute()
    {
        $sys_employee_assigned_department = SysEmployeeAssignedDepartment::where('sys_employee_id', $this->sys_employee_id)
            ->where('is_current', 1)->get('sys_department_id')->first();
        if (!$sys_employee_assigned_department) {
            return null;
        }

        $sys_department = SysDepartment::find($sys_employee_assigned_department->sys_department_id);
        if (!$sys_department) {
            return null;
        }

        return $sys_department->name;
    }
}
