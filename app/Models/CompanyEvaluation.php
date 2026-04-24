<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyEvaluation extends Model
{
    protected $table = 'company_evaluations';

    protected $fillable = [
        'commitment_discipline',
        'communication_teamwork',
        'technical_skills',
        'general_feedback',
        'is_final',
        'overall_assessment',
        'internships_id',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internships_id');
    }
}