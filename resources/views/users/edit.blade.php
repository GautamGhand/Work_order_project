
@include('layouts.dashboard')

<section>
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        <label>First Name</label>
        <input type="text" name="first_name" required value="{{ $user->first_name }}">
        <x-error name="first_name" />
        <label>Last Name</label>
        <input type="text" name="last_name" required value="{{ $user->last_name }}">
        <x-error name="last_name" />
        <label>Email</label>
        <input type="email" name="email" required value="{{ $user->email }}" disabled>
        <x-error name="email" />
        @if($user->is_employee)
                <select name="manager_id">
                    @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                    @endforeach
                </select>
        @endif
        <input type="submit" name="submit" value="Update User" class="btn btn-primary"> 
        <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancel</a>
    </form>
</section>