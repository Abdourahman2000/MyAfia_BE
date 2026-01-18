<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\PatientGlobal;
use App\Models\Diagnose;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'appointments';

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function diagnostic()
    {
        return $this->hasOne(Diagnose::class, 'appoint_id');
    }

    public function patientGlobal()
    {
        return $this->belongsTo(PatientGlobal::class, 'patient_global');
    }
}