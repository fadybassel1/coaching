<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Post as postResource;
use App\models\Post;
use Exception;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function userGroups()
    {
        $userGroups = Auth::user()->groups()->paginate(3);
        return response(['data' => ['userGroups' => $userGroups]]);
    }


    public function showGroups($keyword)
    {

        $results = Group::where('name', 'like', "%$keyword%")->limit(8)->get();
        return response(['data' => ['results' => $results]]);
    }

    public function show($id)
    {

        $group = Group::findOrFail($id);
        return view('user.group', compact('group'));
    }
    public function showPosts($id)
    {
        $posts = Post::orderBy('created_at', 'Desc')->where('group_id', $id)->with('user')->with('images')->withCount('likes')->withCount('comments')->paginate(10);
        foreach ($posts as $post) {
            if ($post->likes->contains(Auth::user()->id))
                $post->liked = true;
            else
                $post->liked = false;
        }
        return response(['data' => $posts]);
    }

    public function requestGroupJoin($group_id)
    {
        try {
            DB::table('group_request')->insert(
                ['user_id' => Auth::user()->id, 'group_id' => $group_id]
            );
            return ['success' => true];
        } catch (Exception $e) {

            return ['success' => false, 'Exception' => $e->getMessage()];
        }
    }
}
