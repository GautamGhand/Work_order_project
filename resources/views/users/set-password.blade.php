@include('layouts.main')

<section>
    <form action="{{ route('setpassword',$user) }}" method="POST">
        @csrf
        <h1>Set Password</h1>
        <label for="password" class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" required>
        <x-error name="password"/>
        <label for="cpassword" class="form-label">Confirm Password</label>
        <input type="password" name="cpassword" class="form-control" required>
        <x-error name="cpassword"/>
        <div class="buttons">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="submit" name="submit" value="Set Password" class="btn btn-primary">
        </div>
    </form>
</section>