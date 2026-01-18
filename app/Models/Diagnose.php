<?php

namespace App\Models;


use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnose extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'diagnoses';

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appoint_id');
    }
}
