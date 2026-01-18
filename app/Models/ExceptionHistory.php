<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExceptionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ssn',                  // Pour les patients
        'compte_cotisant',      // Pour les employeurs
        'nom',                  // Nom du patient ou de l'employeur
        'date_fin_exception',
        'type_exception',       // 'patient' ou 'employer'
        'reason',              // Pour les patients (protocol d'accord pour employeur)
    ];

    // Définir les constantes pour les types d'exception
    const TYPE_PATIENT = 'patient';
    const TYPE_EMPLOYER = 'employer';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope pour filtrer les exceptions patient
    public function scopePatients($query)
    {
        return $query->where('type_exception', self::TYPE_PATIENT);
    }

    // Scope pour filtrer les exceptions employeur
    public function scopeEmployers($query)
    {
        return $query->where('type_exception', self::TYPE_EMPLOYER);
    }
}