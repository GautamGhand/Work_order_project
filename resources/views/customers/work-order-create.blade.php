@include('layouts.dashboard')

<section>
    <form method="POST" action="{{ route('work-orders.store') }}" enctype="multipart/form-data">
        @csrf
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}">
        <x-error name="title"/>
        <label>Note</label>
        <textarea name="note">{{ old('note') }}</textarea>
        <x-error name="note"/>
        <div class="mb-3">
            <label for="file" class="form-label">Attachment (optional)</label>
            <input type="file" name="file" class="form-control">
            <x-error name="file" />
            <p>Supported Attachments:- jpg , jpeg , png , mp4 , pdf , ppt , xlsx , doc , docx , csv , txt , gif , mp3</p>
        </div>
        <input type="submit" value="Create" name="submit">
    </form>
</section>