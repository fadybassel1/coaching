<?php

namespace App\Http\Controllers;

use App\models\Comment;
use App\models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($post){
    
        $comments=Comment::where('post_id',$post)->paginate(10);
        return \response()->json($comments);
    }

    public function viewComments($post){
    
        return view('admin.comment',compact('post'));
    }
}
