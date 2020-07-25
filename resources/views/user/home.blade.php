@extends('layouts.app')

@section('content')
<style>
  body.modal-open {
    overflow: hidden;
  }
</style>
<div id="app">
  <div class="container-fluid">

    <div class="row">
      <!-- Sidebar Widgets Column -->
      <home-group></home-group>
      <div class="col-lg-7">
        {{-- <post-component posturl='/user/api/recent-posts' commenturl="/admin/post-comment/"> </post-component>  --}}
        <home-nav></home-nav>
      </div>
      <div class="col-md-2">
        <div class="card my-4">
          <h5 class="card-header">popular Tracks...</h5>
          <ul class="list-group">
            @foreach ($popularTracks as $track)
            <li class="list-group-item"> # <a href=""> {{$track->name}} </a></li>
            @endforeach
          </ul>

        </div>
      </div>
    </div>


  </div>
  <!-- /.row -->

</div>
@endsection