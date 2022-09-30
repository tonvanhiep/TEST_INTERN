<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Latin:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    @yield('css')
    <div class="container-fluid dashboard">
        <div class="d-flex align-items-start">

            @include('components.admin-menu')

            <div class="col-md-10" id="div-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/admin-style.js')}}"></script>
    @yield('js')
</body>
</html>
