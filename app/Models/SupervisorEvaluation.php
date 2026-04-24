<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupervisorEvaluation extends Model
{
    protected $table = 'supervisors_evaluations';
    use SoftDeletes;
    protected $fillable = [
        'overall_assessment',
        'commitment',
        'skills',
        'communication',
        'general_feedback',
        'is_final',
        'internships_id',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internships_id');
    }
}