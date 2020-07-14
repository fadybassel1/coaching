<?php

namespace App\Http\Controllers;

use App\models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function index(){
      $posts=Post::orderBy('id')->paginate(10);
      return \response()->json($posts);
   }
}
