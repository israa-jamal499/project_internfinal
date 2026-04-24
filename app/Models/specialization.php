<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class specialization extends Model
{
        use SoftDeletes;

    protected $fillable = [
        'college_id',
        'name',
    ];

    // العلاقة مع الكلية
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function opportunities()
{
    return $this->belongsToMany(
        Opportunity::class,
        'opportunity_specializations',
        'specializations_id',
        'opportunities_id'
    );
}
}
