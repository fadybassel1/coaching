<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class GroupRequest extends Model
{
    
    public function group(){
       return $this->belongsTo('App\models\Group');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
     }
}
