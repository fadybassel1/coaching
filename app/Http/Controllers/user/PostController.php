<?php

namespace App\Http\Controllers\user;

use App\models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Post as postResource;
class PostController extends Controller
{
   public function index(){
      $posts=Post::orderBy('id')->with('user')->paginate(10);
      return postResource::collection($posts);

   }
}
