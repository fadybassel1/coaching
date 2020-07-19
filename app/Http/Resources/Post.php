<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {    
        $data=parent::toArray($request);
      
            if($data['created_at']){
            $date = Carbon::parse($data['created_at']);
           $data['created_at']=$date->diffForHumans();
            }
        return $data;
    }

 

}
