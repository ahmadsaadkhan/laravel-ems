@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:10px;">

    <a href="{{isset($id)? route('event.userlist.export', $id) : route('userlist.export')}}" class="btn btn-success float-end mb-5" id="presentationsBtn">Export</a>
    <table id="datatable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>User Name</th>
                <th>IP Address</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usersList as $index => $userList)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ $userList->event_name }}
                </td>
                <td>
                    {{ $userList->username }}
                </td>
                <td>
                    {{ $userList->ip_address }}
                </td>
                <td>
                    {{ $userList->created_at }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="{{asset('js/jquery.min.js')}}"></script>
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
<script>
    function deleteEvent(eventId) {
        var isConfirmed = window.confirm("Are you sure you want to delete this event?");
        if (isConfirmed) {
            axios({
                    method: 'delete',
                    url: '/event-delete/' + eventId,
                })
                .then(response => {
                    alert('Event deleted successfully:', response.data);
                    window.location.reload();
                })
                .catch(error => {
                    alert('Error deleting event:', error);
                });
        } else {
            console.log('Deletion canceled');
        }
    }
</script>
@endsection