<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    public $guarded=[];

    public function groups(){
        return $this->hasMany('App\models\Group');
    }
}
