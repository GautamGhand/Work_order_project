@include('layouts.dashboard')

<section>
    <form method="POST" action="{{ route('users.store.employees') }}">
        @csrf
        <label>First Name</label>
        <input type="text" name="first_name" required value="{{ old('first_name') }}">
        <x-error name="first_name" />
        <label>Last Name</label>
        <input type="text" name="last_name" required value="{{ old('last_name') }}">
        <x-error name="last_name" />
        <label>Email</label>
        <input type="email" name="email" required value="{{ old('email') }}">
        <x-error name="email" />
        <label>Managers</label>
        <select name="manager_id">
            @foreach($managers as $manager)
                <option value="{{ $manager->id }}" >{{ $manager->full_name }}</option>
            @endforeach
        </select>
        <x-error name="manager_id" />
        <input type="submit" name="submit" value="Create User" class="btn btn-primary"> 
        <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancel</a>
    </form>
</section>