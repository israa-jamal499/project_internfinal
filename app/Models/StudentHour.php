<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentHour extends Model
{
    protected $table = 'student_hours';

    protected $fillable = [
        'work_date',
        'hours',
        'description',
        'status',
        'supervisor_feedback',
        'submitted_at',
        'reviewed_at',
        'internships_id',
    ];

    protected $casts = [
        'work_date' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internships_id');
    }
}
