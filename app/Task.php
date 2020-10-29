<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $appends = [
        'created',
        'assinge',
        'author'
    ];

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'author_id',
        'status'
    ];

    public function getCreatedAttribute()
    {
        if (empty($this->created_at)) {
            return null;
        }

        return $this->created_at->toFormattedDateString();
    }

    public function getAssingeAttribute()
    {
        if (empty($this->user_id)) {
            return null;
        }

        return $this->assinge()->first()->name;
    }

    public function getAuthorAttribute()
    {
        if (empty($this->author_id)) {
            return null;
        }

        return $this->author()->first()->name;
    }

    public function assinge()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}
