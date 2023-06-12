@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">{{ ucfirst("dashboard") }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route("menu.index") }}">{{ ucfirst("menu") }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit {{ ucfirst("menu") }}</li>
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
                Edit {{ ucfirst("menu") }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route("menu.update", $menu->id) }}" method="POST">
                @csrf @method("PUT")
                <div class="form-group">
                    <label for="method">{{ ucfirst('method') }}</label>
                    <select class="form-control" name="method">
                        <option value="GET" @if($menu->method == "GET") {{ "selected" }} @endif>GET</option>
                        <option value="POST" @if($menu->method == "POST") {{ "selected" }} @endif>POST</option>
                        <option value="RESOURCE" @if($menu->method == "RESOURCE") {{ "selected" }} @endif>RESOURCE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">{{ ucfirst('name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name..." value="{{ $menu->name }}" required>
                </div>
                <div class="form-group">
                    <label for="icon">{{ ucfirst('icon') }}</label>
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter icon..." value="{{ $menu->icon }}">
                </div>
                <div class="form-group">
                    <label for="route">{{ ucfirst('route') }}</label>
                    <input type="text" class="form-control" id="route" name="route" placeholder="Enter route..." value="{{ $menu->route }}" required>
                </div>
                <div class="form-group">
                    <label for="is_serialized">{{ ucfirst('serialization') }}</label>
                    <select class="form-control" name="is_serialized">
                        <option value="0" @if($menu->is_serialized == "0") {{ "selected" }} @endif>No</option>
                        <option value="1" @if($menu->is_serialized == "1") {{ "selected" }} @endif>Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
