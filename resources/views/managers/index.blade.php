@include('layouts.main')
@include('layouts.dashboard')

<section>
<table class="table table-striped">
    <th>Full Name</th>
    <th>Email</th>
    <th>Role</th>
@foreach($employees as $employee)
    <tr>
        <td>{{ $employee->full_name }}</td>
        <td>{{ $employee->email }}</td>
        <td>{{ $employee->role->name }}</td>
    </tr>
@endforeach
</section>