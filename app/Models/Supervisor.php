<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supervisor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'city_id',
        'college_id',
        'full_name',
        'phone',
        'notes',
        'status',
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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function internships()
{
    return $this->hasMany(Internship::class, 'supervisors_id');
}
}