@extends('layouts.app')

@section('content')
    <div id="app">
        <comment-component :id={{json_encode($post)}}></comment-component>
    </div>
@endsection
