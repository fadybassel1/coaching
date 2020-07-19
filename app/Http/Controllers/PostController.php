<?php

namespace App\Http\Controllers;

use App\models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\Post as postResource;
class PostController extends Controller
{
   public function index(){
      $posts=Post::orderBy('id')->with('user')->paginate(10);
      return postResource::collection($posts);
   }
}
