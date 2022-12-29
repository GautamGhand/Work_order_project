
@include('layouts.dashboard')

@if(!Auth::user()->is_admin)
<section>
    <main>
        <section class="tbl">
            <table class="table table-striped">
                <th>Title</th>
                <th>Note</th>
                 <th>Created At</th>
                <th>Status</th>
                <th>Edit</th>
                @foreach($workorders as $workorder)
                    <tr>
                        <td>{{ $workorder->title }}</td>
                        <td>{{ $workorder->note }}</td>
                        <td>{{ $workorder->created_at }}</td>
                        <td>
                            @if($workorder->status_id == 1)
                                <SPAN><P>OPEN</P></SPAN>
                            @elseif($workorder->status_id == 2)
                                <SPAN><P>In-Progress</P></SPAN>
                            @elseif($workorder->status_id == 3)
                                <SPAN><P>Resolved</P></SPAN>
                            @elseif($workorder->status_id == 4)
                                <SPAN><P>Closed</P></SPAN>
                            @else
                                <SPAN><P>Re-Assign</P></SPAN>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('work-order.status.create', $workorder) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
        </section>
    </main>
</section>
@else
    <table  class="table table-striped">
        <th>Title</th>
        <th>Note</th>
        <th>Status</th>
        <th>Created_At</th>
        <th>Edit</th>
    @foreach($allworkorders as $workorder)
        <tr>
            <td>{{ $workorder->title }}</td>
            <td>{{ $workorder->note }}</td>
            <td>{{ $workorder->status->name }}</td>
            <td>{{ $workorder->created_at }}</td>
            <td>
                <a href="{{ route('work-order.status.create', $workorder) }}" class="btn btn-primary">Edit</a>
            </td>
        </tr>
    @endforeach
@endif

