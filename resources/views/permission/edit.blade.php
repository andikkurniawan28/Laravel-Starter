@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">{{ ucfirst("dashboard") }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route("permission.index") }}">{{ ucfirst("permission") }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit {{ ucfirst("permission") }}</li>
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
                Edit {{ ucfirst("permission") }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route("permission.update", $permission->id) }}" method="POST">
                @csrf @method("PUT")
                <div class="form-group">
                    <label for="role_id">{{ ucfirst('role') }}</label>
                    <select class="form-control" id="role_id" name="role_id">
                        @foreach ($global['role'] as $role)
                            <option value="{{ $role->id }}"
                            @if($role->id == $permission->role_id) {{ "selected" }} @endif
                            >{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="menu_id">{{ ucfirst('menu') }}</label>
                    <select class="form-control" id="menu_id" name="menu_id">
                        @foreach ($global['menu'] as $menu)
                            <option value="{{ $menu->id }}"
                            @if($menu->id == $permission->menu_id) {{ "selected" }} @endif
                            >{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
