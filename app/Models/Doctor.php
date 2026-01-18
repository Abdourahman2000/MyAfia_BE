<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\UserMedical;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';

    public function user() {
        return $this->belongsTo(UserMedical::class, 'user_id');
    }

    public function appointments() {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
    public function todayAppointments() {
        return $this->hasMany(Appointment::class, 'doctor_id')->where('date','=',Carbon::now()->toDateString());
    }
    public function served() {
        return $this->hasMany(Appointment::class, 'doctor_id')->where('status','=',1);
    }
    public function diagnose() {
        return $this->hasMany(Appointment::class, 'doctor_id')->where('diagnose','=',1);
    }
}
