@extends('layouts.app')

@section('content')
<style>
  body.modal-open {
    overflow: hidden;

  }

  body {
    height: 100%;
  }

  .scrollbar-near-moon::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
    background-color: #F5F5F5;
    border-radius: 10px;
  }

  .scrollbar-near-moon::-webkit-scrollbar {
    width: 8px;
    background-color: #F5F5F5;
  }

  .scrollbar-near-moon::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
    background-image: -webkit-gradient(linear, left bottom, left top, from(#5ee7df), to(#b490ca));
    background-image: -webkit-linear-gradient(bottom, #5ee7df 0%, #b490ca 100%);
    background-image: linear-gradient(to top, #5ee7df 0%, #b490ca 100%);
  }

  .scrollbar-near-moon {
    scrollbar-color: #b490ca #F5F5F5;
  }


  .carousel-multi-item.v-2 .carousel-inner .carousel-item.active,
  .carousel-multi-item.v-2 .carousel-item-next,
  .carousel-multi-item.v-2 .carousel-item-prev {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
  }

  .carousel-multi-item.v-2 .carousel-item-right.active,
  .carousel-multi-item.v-2 .carousel-item-next {
    -webkit-transform: translateX(50%);
    -ms-transform: translateX(50%);
    transform: translateX(50%);
  }

  .carousel-multi-item.v-2 .carousel-item-left.active,
  .carousel-multi-item.v-2 .carousel-item-prev {
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
  }

  .carousel-multi-item.v-2 .carousel-item-right,
  .carousel-multi-item.v-2 .carousel-item-left {
    -webkit-transform: translateX(0);
    -ms-transform: translateX(0);
    transform: translateX(0);
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