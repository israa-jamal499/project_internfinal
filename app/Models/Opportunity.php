<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'type',
        'required_hours',
        'seats',
        'filled_seats',

        'deadline',
        'status',
        'requirements',
        'benefits',
        'cities_id',
        'companies_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cities_id');
    }

    public function specializations()
{
    return $this->belongsToMany(
        \App\Models\Specialization::class,
        'opportunity_specializations',
        'opportunities_id',
        'specializations_id'
    );
}

    public function applications()
    {
        return $this->hasMany(Application::class, 'opportunities_id');
    }

    public function image()
{
    return $this->morphOne(Image::class, 'imageable');
}
public function internships()
{
    return $this->hasMany(Internship::class, 'opportunities_id');
}
}
