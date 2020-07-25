<?php

namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $guarded = [];

  public function getCreatedAtAttribute($date)
  {

    return Carbon::createFromTimestamp(\strtotime($date))->diffForHumans();
  }

  public function user()
  {
    return  $this->belongsTo('App\User');
  }

  public function post()
  {
    return  $this->belongsTo('App\models\Post');
  }
}
