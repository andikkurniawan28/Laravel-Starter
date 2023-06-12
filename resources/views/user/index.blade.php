@extends('layouts.app')

@section('content')

    @include('components.alert', [
        'message' => Session::get('success'),
        'color' => 'success',
        'errors' => $errors,
    ])

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">{{ ucfirst("user") }}</h5>
            <br>
            <a href="{{ route("user.create") }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i>
                {{ ucfirst("create") }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ strtoupper("id") }}</th>
                            <th>{{ ucfirst("role") }}</th>
                            <th>{{ ucfirst("name") }}</th>
                            <th>{{ ucfirst("status") }}</th>
                            <th>{{ ucfirst("timestamp") }}</th>
                            <th>{{ ucfirst("action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->role->name ?? "" }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if($user->is_activated === 0)
                                <span class="badge badge-pill badge-dark"><i class="fas fa-ban"></i> Inactive</span>
                                @elseif($user->is_activated === 1)
                                <span class="badge badge-pill badge-primary"><i class="fas fa-check"></i> Active</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="if(!confirm('Data will deleted, are you sure?')){return false;}">
                                    @csrf @method("DELETE")
                                    <a href="{{ route("user.edit", $user->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i> {{ ucfirst("edit") }}</a>
                                    @if($user->is_activated === 0)
                                    <a href="{{ route("user.activation", $user->id) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-check"></i> {{ ucfirst("activate") }}</a>
                                    @elseif($user->is_activated === 1)
                                    <a href="{{ route("user.activation", $user->id) }}" class="btn btn-outline-dark btn-sm"><i class="fas fa-ban"></i> {{ ucfirst("ban") }}</a>
                                    @endif
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
