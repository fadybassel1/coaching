<?php

namespace App\Http\Controllers\admin;

use App\models\Group;
use App\models\GroupRequest;
use App\Http\Controllers\Controller;
use App\models\Post;
use App\models\Track;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function groups()
    {
        $groups = Group::where('admin_id', Auth::guard('admin')->user()->id)->with('track')->get();
        return view('admin.groups', compact('groups'));
    }

    public function group_requests($id)
    {
        $requests = GroupRequest::where('group_id', $id)->with('user')->with('group')->get();
        $groupName = Group::where('id', $id)->select('name')->get()[0]['name'];
        return view('admin.group_requests', compact('requests', 'groupName'));
    }

    public function accept_request($groupID, $userID)
    {
        DB::table('group_users')->insert(
                ['user_id' => $userID, 'group_id' => $groupID]
            );
        GroupRequest::where('user_id', $userID)->where('group_id', $groupID)->delete();
        return redirect()->back();
    }

    public function reject_request($groupID, $userID)
    {
        GroupRequest::where('user_id', $userID)->where('group_id', $groupID)->delete();
        return redirect()->back();
    }

    public function view_create_group()
    {
        $tracks = Track::all();
        return view('admin.createGroup', compact('tracks'));
    }

    public function create_group(Request $request)
    {
        $this->validate($request, [
            'groupPhoto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('groupPhoto')) {
            $image = $request->file('groupPhoto');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            Group::create([
                'name' => $request['groupName'],
                'admin_id' => Auth::user()->id,
                'track_id' => $request['trackID'],
                'photo' => $name
            ]);

            return back()->with('success','Image Upload successfully');
        }
    }

    public function group_members($id)
    {
        $members = Group::where('id', $id)->with('users')->first();
        $gname = Group::where('id', $id)->get()[0]->name;
        return view('admin.group_members', compact('members', 'gname', 'id'));
    }

    public function remove_group_member($memberID, $groupID)
    {
        DB::table('group_users')->where('user_id', $memberID)->where('group_id', $groupID)->delete();
        return redirect()->back();
    }
}
