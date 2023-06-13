@extends("layouts.app_auth")

@section("content")

    <form class="user" method="POST" action="{{ route("login.process") }}">

        @csrf @method("POST")

        <div class="form-group">
            <input type="text" class="form-control form-control-user" id="username" aria-describedby="username"
                placeholder="Enter username..." name="username" required autofocus>
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-user" id="password" placeholder="Enter password..." name="password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Login
        </button>

        <hr>

        <div class="text-center">
            <a class="small" href="{{ route("register") }}">Register</a>
        </div>

    </form>

@endsection
