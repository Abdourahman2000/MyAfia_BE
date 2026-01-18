<?php

namespace App\Models;

use Attribute;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserMedical extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'sqlsrv2';
    protected $table = 'users';

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
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id');
    }



    protected $defaultRoles = [
        'user',
        'doctor',
        'generalist_cs1',
        'generalist_cs2',
        // 'generalist_arta',
        'admin'
    ];

    public function getRoles()
    {
        $user_roles = explode(',', $this->role);
        $defaultRoles = $this->defaultRoles;
        $result = [];
        foreach ($user_roles as $user_role) {
            if (array_key_exists($user_role, $defaultRoles)) {
                $result[] = $defaultRoles[$user_role];
            };
        }
        return $result;
    }
}