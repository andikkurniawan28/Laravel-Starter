<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $global["app_name"] }}</title>

    <!-- Custom fonts for this template-->
    <link href="/admin/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/admin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-{{ $global["app_color"] }}">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-4 col-lg-4 col-md-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="p-5">

                            <div class="text-center">
                                <img src="{{ "/app_icon/".$global["app_icon"] }}" alt="app_icon" title="app_icon" width="150" height="150">
                            </div>

                            @include("components.alert", [
                                "message" => Session::get("success"),
                                "color" => "danger",
                                "errors" => $errors,
                            ])

                            <form class="user" method="POST" action="{{ route("login.process") }}">
                                @csrf @method("POST")
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user"
                                        id="username" aria-describedby="username"
                                        placeholder="Enter username..." name="username" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                        id="password" placeholder="Enter password..." name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route("register") }}">Register</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/admin/jquery/jquery.min.js"></script>
    <script src="/admin/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/admin/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/admin/js/sb-admin-2.min.js"></script>

</body>

</html>
