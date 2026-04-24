<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'city_id',
        'name',
        'website',
        'description',
        'status',
        'address',
        'field_name',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function images()
{
    return $this->morphMany(Image::class, 'imageable');
}

public function opportunities()
{
    return $this->hasMany(Opportunity::class);
}
public function internships()
{
    return $this->hasMany(Internship::class, 'companies_id');
}
}