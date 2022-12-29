@include('layouts.dashboard')

<section>
    <main>
        <section class="tbl">
            <table class="table table-striped">
                <th>Title</th>
                <th>Note</th>
                <th>Status</th>
                <th>Edit</th>
                @foreach($workorders as $workorder)
                    <tr>
                        <td>{{ $workorder->title }}</td>
                        <td>{{ $workorder->note }}</td>
                        <td>
                            @if($workorder->status_id == 4)
                                <SPAN><P>Closed</P></SPAN>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('work-order.status.create', $workorder) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </table>