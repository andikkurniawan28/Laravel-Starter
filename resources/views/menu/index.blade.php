@extends('layouts.app')

@section('content')

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        Please make sure your <strong>route</strong> is registered !
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @include('components.alert', [
        'message' => Session::get('success'),
        'color' => 'success',
        'errors' => $errors,
    ])

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">{{ ucfirst("menu") }}</h5>
            <br>
            <a href="{{ route("menu.create") }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i>
                {{ ucfirst("create") }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ strtoupper("id") }}</th>
                            <th>{{ ucfirst("name") }}</th>
                            <th>{{ ucfirst("method") }}</th>
                            <th>{{ ucfirst("icon") }}</th>
                            <th>{{ ucfirst("route") }}</th>
                            <th>{{ ucfirst("timestamp") }}</th>
                            <th>{{ ucfirst("action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menu as $menu)
                        <tr>
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->method }}</td>
                            <td><i class="fas fa-{{ $menu->icon }}"></i></td>
                            <td>{{ $menu->route }}</td>
                            <td>{{ $menu->created_at }}</td>
                            <td>
                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" onsubmit="if(!confirm('Data will deleted, are you sure?')){return false;}">
                                    @csrf @method("DELETE")
                                    <a href="{{ route("menu.edit", $menu->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i> {{ ucfirst("edit") }}</a>
                                    {{-- <a href="{{ route("menu.show", $menu->id) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-info"></i> {{ ucfirst("info") }}</a> --}}
                                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class="fas fa-trash"></i> {{ ucfirst("delete") }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection
