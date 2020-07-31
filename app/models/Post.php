<?php

namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($date)
    {

        return Carbon::createFromTimestamp(\strtotime($date))->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->belongsToMany('App\User', 'user_post_like', 'post_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\models\Comment');
    }

    public function images()
    {
        return $this->hasMany('App\models\Image');
    }

    public function group()
    {
        return $this->belongsTo('App\models\Group');
    }
}
