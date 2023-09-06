<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysPositions extends Model
{
    use HasFactory;


    // protected $appends = ['full_name', 'full_name_fmle'];

    /**
     * Get the employees's full name.
     *
     * @return string
     */


    // public function getFullNameFmleAttribute()
    // {
    //     $last_name = $this->last_name;
    //     $first_name = $this->first_name;
    //     $middle_name = $this->middle_name && strlen($this->middle_name) > 0 ? " " . $this->middle_name[0] . "." : "";
    //     $ext = $this->ext && strlen($this->ext) > 0 ? " " . $this->ext : "";

    //     return "{$first_name} {$middle_name} {$last_name}{$ext}";
    // }

    // public function getFullNameAttribute()
    // {
    //     $last_name = $this->last_name;
    //     $first_name = $this->first_name;
    //     $middle_name = $this->middle_name && strlen($this->middle_name) > 0 ? " " . $this->middle_name[0] . "." : "";
    //     $ext = $this->ext && strlen($this->ext) > 0 ? " " . $this->ext : "";


    //     return "{$last_name}, {$first_name}{$middle_name}{$ext}";
    // }
}
