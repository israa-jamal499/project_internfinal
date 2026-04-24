<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Internship extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'required_hours',
        'completed_hours',
        'total_hours',
        'notes',
        'tasks',
        'students_id',
        'companies_id',
        'supervisors_id',
        'opportunities_id',
        'applications_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'students_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisors_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class, 'opportunities_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'applications_id');
    }
    public function weeklyReports()
{
    return $this->hasMany(WeeklyReport::class, 'internships_id');
}

public function supervisorEvaluation()
{
    return $this->hasOne(SupervisorEvaluation::class, 'internships_id');
}
public function companyEvaluation()
{
    return $this->hasOne(CompanyEvaluation::class, 'internships_id');
}
public function studentHours()
{
    return $this->hasMany(StudentHour::class, 'internships_id');
}

public function certificate()
{
    return $this->hasOne(Certificate::class, 'internships_id');
}

public function messages()
{
    return $this->hasMany(Message::class, 'internships_id');
}
}