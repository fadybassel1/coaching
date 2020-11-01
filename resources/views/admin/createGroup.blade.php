@extends('layouts.app')

@section('content')

<div class="container">
    <form enctype="multipart/form-data" action="{{ route('admin.create_group') }}" method="POST">
        @csrf
        <h3>Create new group</h3>
        <input name="groupName" type="text" required>
        <select name="trackID" required>
            @foreach ($tracks as $track)
            <option value="{{ $track->id }}">{{ $track->name }}</option>
            @endforeach
        </select>
        <input type="file" name="groupPhoto" accept="image/*" required />
        <br>
        <input type="submit" value="Create">
    </form>

</div>
@endsection
