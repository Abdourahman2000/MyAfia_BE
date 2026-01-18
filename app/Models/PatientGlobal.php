<?php

namespace App\Models;

use App\Models\Diagnose;
use App\Models\Appointment;
use App\Models\MemberFamilyAmu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientGlobal extends Model
{

    use HasFactory;
    protected $table = 'patient_global';
    

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'patient_global');
    }
    
    public function listDiagnose()
    {
        return $this->hasManyThrough(Diagnose::class, Appointment::class, 'patient_global', 'appoint_id');
    }
    public function visits()
    {
        return $this->hasMany(Appointment::class, 'patient_global');
    }
    
    public function diagnosedAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_global')->where('diagnose', 1);
    }

    public function family($type = null)
    {
        $query = $this->hasMany(PatientGlobal::class, 'ssn', 'ssn');

        if ($type) {
            $query->where('relation_name', $type);
        }

        return $query;
    }

    public function familyRegime()
    {
        return $this->hasOne(MemberFamilyAmu::class, 'SSN', 'ssn')
            ->select(['SSN', 'Regime']) // include 'SSN' so Eloquent can match the records
            ->where('RelationCode', 1);
    }
    public function AMUPrincipal()
    {
        return $this->hasOne(MemberFamilyAmu::class, 'SSN', 'ssn')
            ->where('RelationCode', 1);
    }
}