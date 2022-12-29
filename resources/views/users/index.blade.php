
@include('layouts.dashboard')

<section>
    <nav class="details-nav">
        @if(Auth::user()->is_admin)
            <a href="{{ route('users.create') }}">Create Manager</a>
            <a href="{{ route('users.create.employees') }}">Create Employee</a>
        @endif
    </nav>

    <main>
        <section class="tbl">
            <table class="table table-striped">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Type Of User</th>
                <th>Edit</th>
                @foreach($users as $user)
                    <tr>
                        @if($user->is_admin)
                            @continue
                        @endif
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </section>
    </main>


</section>

</body>
</html>


