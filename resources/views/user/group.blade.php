@extends('layouts.app')

@section('content')
<div id="app">
 

<post-component posturl="/user/api/group-posts/{{$group->id}}" commenturl="/admin/post-comment/"
            likeurl="/admin/post-likes/"></post-component>
 
</div>
@endsection