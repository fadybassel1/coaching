@extends('layouts.app')

@section('content')

<div class="container">
    <h3>{{ $groupName }} Requests</h3>
    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="th-sm">Name</th>
                <th class="th-sm"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $request)
            <tr>
                <td>{{ $request->user->name }}</td>
                <td>
                    <a href="/admin/{{ $request->group->id }}/requestUser/{{ $request->user->id }}/accept"
                        style="btn btn-primary">Accept</a>
                    <a href="/admin/{{ $request->group->id }}/requestUser/{{ $request->user->id }}/reject"
                        style="btn btn-primary">Reject</a>
                </td>
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
