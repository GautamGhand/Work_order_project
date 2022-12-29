@include('layouts.main')


<section class="create">
    <form method="POST" action="{{ route('customers.store') }}">
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
        <label>Password</label>
        <input type="password" name="password" required>
        <x-error name="password" />
        <input type="submit" name="submit" value="Sign Up" class="btn btn-primary">
        <a href="{{ route('login') }}" class="btn btn-dark">Cancel</a>
    </form>
</section>