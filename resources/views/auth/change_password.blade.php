@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">{{ ucfirst("dashboard") }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ ucfirst("change password") }}</li>
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
                {{ ucfirst("change password") }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route("change_password.process") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="password">{{ ucfirst('new password') }}</label>
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth()->user()->id }}">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password..." autofocus required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
