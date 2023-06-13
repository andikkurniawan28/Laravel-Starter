@if($message = Session::get('success'))
    <div class="alert alert-{{ $color }}" role="alert">
        {{ $message }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <p>Error :</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
@endif
