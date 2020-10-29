<?php

namespace App;

use App\Processors\AvatarProcessor;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function file() {
        return $this->belongsTo(File::class);
    }

    public function getAvatarAttribute() {
        return AvatarProcessor::get($this);
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'user_id');
    }

    public function createdTask()
    {
        return $this->hasMany('App\Task', 'author_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role == 2 ? true : false;
    }
}
