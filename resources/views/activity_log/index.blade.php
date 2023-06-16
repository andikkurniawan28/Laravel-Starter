@extends('layouts.app')

@section('content')

    @include('components.alert', [
        'message' => Session::get('success'),
        'color' => 'success',
        'errors' => $errors,
    ])

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">{{ ucfirst("activity log") }}</h5>
            <br>
            @foreach($global["menu"] as $menux)
                @if($menux->name == ucfirst("Activity Log"))
                    @foreach ($menux->documentation as $documentation)
                        <p class="mb-4">{{ $documentation->description }}</p>
                    @endforeach
                @endif
            @endforeach
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ ucfirst("timestamp") }}</th>
                            <th>{{ ucfirst("description") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activity_log as $activity_log)
                        <tr>
                            <td>{{ $activity_log->created_at }}</td>
                            <td>{{ $activity_log->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection
