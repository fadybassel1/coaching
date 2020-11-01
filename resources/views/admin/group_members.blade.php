@extends('layouts.app')

@section('content')

<div class="container">
    <h3>{{ $gname }} members</h3>
    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="th-sm">Name</th>
                <th class="th-sm"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members->users as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td><a href="/admin/{{ $member->id }}/remove_member/{{ $id }}" style="btn btn-primary">Remove</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="2">No Requests for this group</td>
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
