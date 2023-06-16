@extends("layouts.app")

@section("content")

    @include("components.alert", [
        "message" => Session::get("success"),
        "color" => "success",
        "errors" => $errors,
    ])

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">{{ ucfirst("documentation") }}</h5>
            <br>
            @include("components.documentation", ["description" => $description])
            <a href="{{ route("documentation.create") }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus"></i>
                {{ ucfirst("create") }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ strtoupper("id") }}</th>
                            <th>{{ ucfirst("menu") }}</th>
                            <th>{{ ucfirst("description") }}</th>
                            <th>{{ ucfirst("timestamp") }}</th>
                            <th>{{ ucfirst("action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentation as $documentation)
                        <tr>
                            <td>{{ $documentation->id }}</td>
                            <td>{{ $documentation->menu->name ?? "" }}</td>
                            <td>{{ $documentation->description }}</td>
                            <td>{{ $documentation->created_at }}</td>
                            <td>
                                <form action="{{ route("documentation.destroy", $documentation->id) }}" method="POST" onsubmit="if(!confirm('Documentation for menu {{ $documentation->menu->name }} will be deleted, are you sure?')){return false;}">
                                    @csrf @method("DELETE")
                                    <a href="{{ route("documentation.edit", $documentation->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i> {{ ucfirst("edit") }}</a>
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
