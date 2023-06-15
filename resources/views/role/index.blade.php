@extends('layouts.app')

@section('content')

    @include('components.alert', [
        'message' => Session::get('success'),
        'color' => 'success',
        'errors' => $errors,
    ])

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">{{ ucfirst("role") }}</h5>
            <br>
            @foreach($global["menu"] as $menux)
                @if($menux->name == ucfirst("role"))
                    @foreach ($menux->documentation as $documentation)
                        <p class="mb-4">{{ $documentation->description }}</p>
                    @endforeach
                @endif
            @endforeach
            <a href="{{ route("role.create") }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i>
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
                            <th>{{ ucfirst("timestamp") }}</th>
                            <th>{{ ucfirst("action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                <form action="{{ route('role.destroy', $role->id) }}" method="POST" onsubmit="if(!confirm('Data will deleted, are you sure?')){return false;}">
                                    @csrf @method("DELETE")
                                    <a href="{{ route("role.edit", $role->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i> {{ ucfirst("edit") }}</a>
                                    {{-- <a href="{{ route("role.show", $role->id) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-info"></i> {{ ucfirst("info") }}</a> --}}
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
