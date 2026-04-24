<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

  use SoftDeletes;
    protected $fillable = [
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function admin()
{
    return $this->hasOne(Admin::class);
}
public function supervisor()
{
    return $this->hasOne(Supervisor::class);
}

public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}
}