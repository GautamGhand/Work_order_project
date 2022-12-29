@include('layouts.dashboard')

<div>
<div class="card">
    <h2>About WorkOrder</h2>
    <div>
         <span><p>WorkOrder Title</p>{{ $workorder->title }}</span>
    </div>
    <div>
        <span><p>WorkOrder Note</p>{{ $workorder->note }}</span>
    </div>
    <div>
        <span><p>WorkOrder Status</p>{{ $workorder->status->name }}</span>
    </div>
</div>

<h2>History of Work Order</h2>
    @foreach($progresses as $progress)
    <div class="card">
        <div>
           <span><p>Assigned To</p>{{ $progress->assigned_user->full_name}}</span>
        </div>
        <div>
            <span><p>Assigned By</p>{{ $progress->user->full_name }}</span>
        </div>
        <div>
            <span><p>Status</p>{{ $progress->status->name}}</span>
         </div>
        <div>
            <span><p>Note</p>{{ $progress->note }}</span>
        </div>
        <div>
            <span><p>Created_At</p>{{ $progress->created_at }}</span>
        </div>
        <div>
            @if($progress->attachments)
            <i class="bi bi-file"></i>
            <a href="{{ asset('storage/'.$progress->attachments->url) }}" target="_blank">file.{{$progress->attachments->extension}}</a>
            @else
            <h2>No Attachment Added</h2>
            @endif
        </div>
    </div>
    @endforeach

@if(!Auth::user()->is_customer)
<section>
    <h1>Edit Section</h1>
    <form method="POST" action="{{ route('work-order.status.update', $workorder) }}" enctype="multipart/form-data">
        @csrf
        <label>Add Note</label>
        <textarea name="add_note">{{ old('add_note') }}</textarea>
        <x-error name="add_note" />
        <select name="status_id">
            @foreach($statuses as $status)
                @if(Auth::user()->is_admin)
                    @if($status->id == 1 || $status->id==4)
                        <option value="{{ $status->id }}" @if($status->id == $workorder->status_id) selected @endif>{{ $status->name }}</option>
                    @endif
                @elseif(Auth::user()->is_manager)
                        @if($status->id == 1 || $status->id==3)
                        <option value="{{ $status->id }}" @if($status->id == $workorder->status_id) selected @endif>{{ $status->name }}</option>
                        @endif
                    @else
                        @if($status->id == 1 || $status->id==3 || $status->id==2)
                            <option value="{{ $status->id }}" @if($status->id == $workorder->status_id) selected @endif>{{ $status->name }}</option>
                        @endif
                @endif   
            @endforeach
        </select>
        <x-error name="status_id" />
        @if(Auth::user()->is_admin)
            <h1>List Of Managers</h1>
            <label>Managers</label>
            <select name="user_id">
                <option value="">Select</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                @endforeach
            </select>
            <x-error name="user_id" />
        @elseif(Auth::user()->is_manager)
            <h1>List of Employees</h1>
            <label>Employees</label>
            <select name="user_id">
                <option value="">Select</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                @endforeach
            </select>
            <x-error name="user_id" />
        @endif
        <div class="mb-3">
                    <label for="file" class="form-label">Attachment (optional)</label>
            <input type="file" name="file" class="form-control">
            <x-error name="file" />
            <p>Supported Attachments:- jpg , jpeg , png , mp4 , pdf , ppt , xlsx , doc , docx , csv , txt , gif , mp3</p>
        </div>
        <input type="submit" name="submit">
    </form>
</section>
@endif
</div>
