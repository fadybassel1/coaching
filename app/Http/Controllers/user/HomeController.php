<?php

namespace App\Http\Controllers\user;

use App\models\Group;
use App\Http\Controllers\Controller;
use App\models\Post;
use App\models\Track;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //popular tags..
        $popularTracks = Track::withCount('groups')->orderBy('groups_count', 'desc')->limit(5)->get();
        return view('user.home', \compact('popularTracks'));
    }

    public function group_stat()
    {
        $ids = Auth::user()->groups()->pluck('id');
        $tracks = Auth::user()->groups()->pluck('track_id');
        $requestedJoinGroups = DB::table('group_request')->where('user_id', Auth::user()->id)->pluck('group_id');
        //Most popular groups..
        $popularGroups = Group::withCount('users')->whereIn('track_id', $tracks)->whereNotIn('id', $ids)->whereNotIn('id', $requestedJoinGroups)->orderBy('users_count', 'desc')->limit(5)->get();
        //user Groups ordered by Activity...
        $userGroups = Auth::user()->groups()->withCount('posts')->orderBy('posts_count', 'desc')->limit(5)->get();
        return response(['data' => ['popularGroups' => $popularGroups, 'userGroups' => $userGroups]]);
    }
    public function recent_posts()
    {
        $groups = Auth::user()->groups()->pluck('id');
        $posts = Post::whereIn('group_id', $groups)->with('user')->with('images')->with('group')->withCount('likes')->withCount('comments')->orderBy('created_at', 'desc')->paginate(10);
        foreach ($posts as $post) {
            if ($post->likes->contains(Auth::user()->id))
                $post->liked = true;
            else
                $post->liked = false;
        }
        return response(['data' => $posts]);
    }

    public function suggested_groups()
    {
        //return suggested groups based on user tags..

        $groups = Auth::user()->groups()->get();

        foreach ($groups as $group) {
            $ids[] = $group->id;
            $tracks[] = $group->track_id;
        }
        $groups = Group::inRandomOrder()->whereIn('track_id', $tracks)->whereNotIn('id', $ids)->limit(2)->get();
        return response(['data' => ['suggestedGroups' => $groups]]);
    }
}
