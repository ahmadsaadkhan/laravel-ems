@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:10px;">
    <a href="{{route('event.create')}}" class="btn btn-primary focus float-end mb-5" id="presentationsBtn">Add Event</a>

    <table id="datatable" class="table table-striped mt-5" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Event Name</th>
                <th>Event Url</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>User Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $index => $event)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $event->event_name ?? '' }}</td>
                <td>@if(isset($event->event_url)) {{ url('portal') }}/{{ $event->event_url }} @endif</td>
                <td>{{ $event->start_date ?? '' }}</td>
                <td>{{ $event->end_date ?? '' }}</td>
                <td>{{ isset($event->status) && $event->status == 1 ? 'Active' : 'Inactive' }}</td>
                <td>{{ $event->username ?? '' }}</td>

                <td>
                    <a href="{{ route('event.edit',$event->id) }}"><i class="bi bi-pencil-square h4"></i></a>
                    <a href="#" id="deleteEventLink" onclick="deleteEvent('{{$event->id}}');"><i class="bi bi-x-circle h4"></i></a>
                    <a href="{{ route('user.validate-event',$event->event_url) }}" target="_blank"><i class="bi bi-eye h4"></i></a>
                    <a href="{{ route('event.userlist',$event->id) }}"><i class="bi bi-people h4"></i></a>
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