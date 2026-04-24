<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'certificate_number',
        'issue_date',
        'notes',
        'is_issued',
        'internships_id',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'is_issued' => 'boolean',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internships_id');
    }
}
