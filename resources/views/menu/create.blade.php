@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">{{ ucfirst("dashboard") }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route("menu.index") }}">{{ ucfirst("menu") }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create {{ ucfirst("menu") }}</li>
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
                Create {{ ucfirst("menu") }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route("menu.store") }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="method">{{ ucfirst('method') }}</label>
                    <select class="form-control" name="method">
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                        <option value="RESOURCE">RESOURCE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">{{ ucfirst('name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name..." required>
                </div>
                <div class="form-group">
                    <label for="icon">{{ ucfirst('icon') }}</label>
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter icon...">
                </div>
                <div class="form-group">
                    <label for="route">{{ ucfirst('route') }}</label>
                    <input type="text" class="form-control" id="route" name="route" placeholder="Enter route..." required>
                </div>
                <div class="form-group">
                    <label for="is_serialized">{{ ucfirst('serialization') }}</label>
                    <select class="form-control" name="is_serialized">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
