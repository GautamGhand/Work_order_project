@include('layouts.main')


<section>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email" required>
        <x-error name="email"/>
        <label>Password</label>
        <input type="password" name="password" required>
        <x-error name="password" />
        <input type="submit" name="submit" value="Login">
    </form>
    <a href="{{ route('customers.create') }}">Customer Signup</a>
</section>