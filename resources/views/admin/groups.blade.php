@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Your Groups</h3>
    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="th-sm">Name</th>
                <th class="th-sm">Track</th>
                <th class="th-sm"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>{{ $group->track->name }}</td>
                <td><a href="group/{{ $group->id }}/requests" style="btn btn-primary">Requests</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="2">No Groups</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

</script>
@endsection
