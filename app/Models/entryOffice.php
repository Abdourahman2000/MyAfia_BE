<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class entryOffice extends Model
{
    use HasFactory;
    protected $table = 'entry_office';
    protected $fillable = [
        'ref',
        'name',
        'member_id',
        'relation_code',
        'ssn',
        'birth',
        'access_soin',
        'taken_by_name',
        'taken_place',
        'mother_name',
        'photo',
        'exception_status',
        'exception_reason',
        'taken_by',
        'gender',
        'age',
        'history',
        'regime'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'taken_by');
    }

    /**
     * Accessor: Automatically decode the JSON when retrieving.
     */
    public function getHistoryAttribute($value)
    {
        // Decode the JSON into an array
        return json_decode($value, true) ?? [];
    }

    /**
     * Mutator: Automatically encode the array to JSON when saving.
     * Appends new data to the existing history.
     */
    public function setHistoryAttribute($value)
    {
        // Retrieve the current history (if any), which is an array
        $existingHistory = $this->history;

        // Append the new data to the existing history
        $updatedHistory = $existingHistory;
        $updatedHistory[] = $value; // Add new data to history

        // Encode and save the updated history as JSON
        $this->attributes['history'] = json_encode($updatedHistory);
    }
}
