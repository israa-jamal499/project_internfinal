<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
   use HasFactory;
   use SoftDeletes;
    protected $fillable = [
        'user_id',
        'city_id',
        'college_id',
        'specialization_id',
        'full_name',
        'university_number',
        'level',
        'general_status',
        'cv',
        'address',
        'phone',
        'gender',
        'birthdate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function specialization()
{
    return $this->belongsTo(specialization::class);
}
public function images()
{
    return $this->morphMany(Image::class, 'imageable');
}
public function applications()
{
    return $this->hasMany(Application::class, 'students_id');
}
public function internships()
{
    return $this->hasMany(Internship::class, 'students_id');
}
public function image()
{
    return $this->morphOne(Image::class, 'imageable');
}
}
