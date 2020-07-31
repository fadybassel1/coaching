@extends('layouts.app')

@section('content')


@can('post', $group)
<div id="app">
    <post-component posturl="/user/api/group-posts/{{$group->id}}" commenturl="/admin/post-comment/"
        likeurl="/admin/post-likes/"></post-component>

</div>
@else
<div class="card text-center">
    <div class="card-header">
      Hey {{auth()->user()->name}}
    </div>
    <div class="card-body">
        @if (auth()->user()->requests->contains($group->id))
        <h5 class="card-title">Your Request to join this group is pending approval.</h5>
        <p class="card-text">We will let you know when your request is approved.</p>
        <a href="/user/home" class="btn btn-primary">Go Back</a>
        @else
        <h5 class="card-title">Your are not a member in this group.</h5>
        <p class="card-text">Click below to send a Join request.</p>
        <a href="" class="btn btn-primary">Send request</a>
        @endif
        
    </div>
  </div>
@endcan


@endsection