@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">{{ ucfirst("dashboard") }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route("documentation.index") }}">{{ ucfirst("documentation") }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create {{ ucfirst("documentation") }}</li>
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
                Create {{ ucfirst("documentation") }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route("documentation.store") }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="menu_id">{{ ucfirst('menu') }}</label>
                    <select class="form-control" name="menu_id">
                        @foreach ($global["menu"] as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">{{ ucfirst('description') }}</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
