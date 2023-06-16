@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">{{ ucfirst("dashboard") }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ ucfirst("setting") }}</li>
        </ol>
    </nav>

    @include('components.alert', [
        'message' => Session::get('success'),
        'color' => 'success',
        'errors' => $errors,
    ])

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                {{ ucfirst("setting") }}
            </h5>
            <br>
            @foreach($global["menu"] as $menux)
                @if($menux->name == ucfirst("Setting Index"))
                    @foreach ($menux->documentation as $documentation)
                        <p class="mb-4">{{ $documentation->description }}</p>
                    @endforeach
                @endif
            @endforeach
        </div>
        <div class="card-body">
            <form action="{{ route("setting.process") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="app_name">{{ ucfirst('application name') }}</label>
                    <input type="text" class="form-control" id="app_name" name="app_name" placeholder="Enter app_name..." value="{{ $global['app_name'] }}" required>
                </div>
                <div class="form-group">
                    <label for="app_logo">{{ ucfirst('application logo') }}</label>
                    <input type="file" class="form-control-file" id="app_logo" name="app_logo" accept=".jpg,.gif,.png">
                </div>
                <div class="form-group">
                    <label for="app_icon">{{ ucfirst('application icon') }}</label>
                    <input type="file" class="form-control-file" id="app_icon" name="app_icon" accept=".jpg,.gif,.png">
                </div>
                <div class="form-group">
                    <label for="app_color">{{ ucfirst('application color') }}</label>
                    <select name="app_color" class="form-control">
                        <option value="danger" @if($global["app_color"] == "danger") {{ "selected" }} @endif>Red</option>
                        <option value="primary" @if($global["app_color"] == "primary") {{ "selected" }} @endif>Blue</option>
                        <option value="success" @if($global["app_color"] == "success") {{ "selected" }} @endif>Green</option>
                        <option value="warning" @if($global["app_color"] == "warning") {{ "selected" }} @endif>Yellow</option>
                        <option value="info" @if($global["app_color"] == "info") {{ "selected" }} @endif>Lightblue</option>
                        <option value="dark" @if($global["app_color"] == "dark") {{ "selected" }} @endif>Dark</option>
                        <option value="light" @if($global["app_color"] == "light") {{ "selected" }} @endif>Light</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="app_font_color">{{ ucfirst('application font color') }}</label>
                    <select name="app_font_color" class="form-control">
                        <option value="dark" @if($global["app_font_color"] == "dark") {{ "selected" }} @endif>Light</option>
                        <option value="light" @if($global["app_font_color"] == "light") {{ "selected" }} @endif>Dark</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
