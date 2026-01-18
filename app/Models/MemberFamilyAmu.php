<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberFamilyAmu extends Model
{
    use HasFactory;
    protected $table = 'MEMBRE_FAMILLE_AMU';
    // protected $connection = 'sqlsrv2';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'RelationCode' => 'integer',
    ];
}
