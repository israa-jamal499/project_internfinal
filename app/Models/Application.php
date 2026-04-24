<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'cover_letter',
        'status',

        'reviewed_at',
        'students_id',
        'opportunities_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'students_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class, 'opportunities_id');
    }
    public function internship()
{
    return $this->hasOne(Internship::class, 'applications_id');
}
public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id');
    }
}
