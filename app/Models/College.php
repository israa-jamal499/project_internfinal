<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    protected $table = 'colleges';
    use SoftDeletes;
    protected $fillable = ['name'];

    public function specializations()
{
    return $this->hasMany(specialization::class);
}
}