<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    protected $fillable = [
        'week_number',
        'supervisor_feedback',
        'status',
        'submitted_at',
        'reviewed_at',
        'hours_worked',
        'learnings',
        'challenges',
        'tasks_planned',
        'tasks_completed',
        'week_start',
        'week_end',
        'file_path',
        'internships_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'week_start' => 'date',
        'week_end' => 'date',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internships_id');
    }
}
