<?php

namespace App\Http\Controllers;

use App\models\Comment;
use App\models\Post;
use Dotenv\Result\Success;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($post)
    {
        $comments = Comment::where('post_id', $post)->with('user')->orderBy('Created_at', 'DESC')->paginate(10);
        return \response()->json($comments);
    }

    public function addComment(Request $request)
    {
        try {
            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $request['post_id'];
            $comment->text = $request['text'];
            $comment->save();
            return ['success' => true, 'comment' => $comment, 'comment_user' => $comment->user];
        } catch (Exception $e) {
            return ['success' => false];
        }
    }
}
