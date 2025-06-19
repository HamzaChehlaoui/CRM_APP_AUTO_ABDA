<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
/**
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany $notifications
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'branch_id',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // rolation
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function sendEmailVerificationNotification()
{
    $this->notify(new \App\Notifications\CustomVerifyEmail());
}

    public function clients()
    {
        return $this->hasMany(Client::class, 'created_by');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
     public function suivis()
    {
        return $this->hasMany(Suivi::class);
    }
    public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id');
}


public function unreadNotifications()
{
    return $this->notifications()->unread();
}

public function getUnreadNotificationsCountAttribute()
{
    return $this->unreadNotifications()->count();
}
    public const ROLE_MANAGER = 2;

}
