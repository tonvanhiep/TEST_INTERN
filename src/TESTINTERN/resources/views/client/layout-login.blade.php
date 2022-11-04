<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Latin:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body style="background-image: url('{{ asset('assets/images/background.jpg') }}'); background-attachment:local; background-repeat: no-repeat; background-size: cover;">
    <div class="row" style='min-width: 350px; max-width: 600px; width: 100vw; border: darkgray; border-width: thin; border-style: solid; border-radius: 15px;'>
        <div class="card" style="border-radius: 15px;">
            <div class="card-body">
                <a href="{{ url()->previous() }}" class="fw-bold text-body">&larr; 帰る</a>

                @yield('content')

            </div>
        </div>
    </div>
</body>
</html>
