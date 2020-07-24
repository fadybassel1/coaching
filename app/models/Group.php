<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guraded=[];

    public function posts(){
       return $this->hasMany('App\models\Post');
    }
    public function track(){
       return $this->belongsTo('App\models\Track');
    }

    public function users(){
        return $this->belongsToMany('App\User','group_users');
     }
}
