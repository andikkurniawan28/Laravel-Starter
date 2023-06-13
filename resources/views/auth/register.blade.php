@extends("layouts.app_auth")

@section("content")

    <form class="user" method="POST" action="{{ route("register.process") }}">

        @csrf @method("POST")

        <input type="hidden" name="role_id" value="{{ $global["default_role_id"] }}">

        <div class="form-group">
            <input type="text" class="form-control form-control-user" id="name" aria-describedby="name"
                placeholder="Enter name..." name="name" required autofocus>
        </div>

        <div class="form-group">
            <input type="text" class="form-control form-control-user" id="username" aria-describedby="username"
                placeholder="Enter username..." name="username" required>
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-user" id="password" placeholder="Enter password..." name="password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">
            Register
        </button>

        <hr>

        <div class="text-center">
            <a class="small" href="{{ route("login") }}">Login</a>
        </div>

    </form>

@endsection
