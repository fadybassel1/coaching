@extends('layouts.app')

@section('content')
<div id="app">

    <post-component posturl='/admin/getposts' commenturl="/admin/post-comment/"></post-component>
</div>
@endsection