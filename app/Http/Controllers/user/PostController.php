<?php

namespace App\Http\Controllers\user;

use App\models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Post as postResource;
use Exception;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
   public function index()
   {
      $posts = Post::orderBy('id')->with('user')->paginate(10);
      return postResource::collection($posts);
   }

   public function addNewPost(Request $request)
   {
      try {
         $post = new Post();
         $post->user_id = Auth::user()->id;
         $post->group_id = 1;
         $post->text = $request['text'];
         $post->user->name = Auth::user()->name;
         $post->save();
         return ['success' => true, 'post' => $post];
      } catch (Exception $e) {
         return ['success' => false];
      }
   }

   public function addLike($postID)
   {
      $post = Post::where('id', $postID)->first();
      if (!$post->likes->contains(Auth::user()->id)) {
         $post->likes()->attach(Auth::user()->id);
         return response()->json(['post_liked' => true], 201);
      }
   }

   public function deleteLike($postID)
   {
      $post = Post::where('id', $postID)->first();
      $post->likes()->detach(Auth::user()->id);
      return response(null, 204);
   }

   public function getLikes($postID)
   {
      $likes = Post::where('id', $postID)->first();
      return \response()->json($likes->likes()->paginate(10));
   }
}
