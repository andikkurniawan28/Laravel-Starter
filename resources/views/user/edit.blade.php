@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">{{ ucfirst("dashboard") }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route("user.index") }}">{{ ucfirst("user") }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit {{ ucfirst("user") }}</li>
        </ol>
    </nav>

    @include('components.alert', [
        'message' => Session::get('success'),
        'color' => 'success',
        'errors' => $errors,
    ])

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit {{ ucfirst("user") }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route("user.update", $user->id) }}" method="POST">
                @csrf @method("PUT")
                <div class="form-group">
                    <label for="role_id">{{ ucfirst('role') }}</label>
                    <select class="form-control" id="role_id" name="role_id">
                        @foreach ($global['role'] as $role)
                            <option value="{{ $role->id }}"
                            @if($role->id == $user->role_id) {{ "selected" }} @endif
                            >{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">{{ ucfirst('name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name..." value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="username">{{ ucfirst('username') }}</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username..." value="{{ $user->username }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
