<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理ログイン</title>

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
                <a href="{{ route('home') }}" class="fw-bold text-body">&larr; ホームページに戻る</a>

                <h2 class="text-uppercase text-center mb-4 mt-4">ログイン</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.p_loginManagement') }}">
                    @csrf
                    <div class="form-outline mb-3">
                        <label class="form-label" for="inp-email">メール *</label>
                        <input type="text" id="inp-email" name="email" class="form-control"/>
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label" for="inp-pass">パスワード *</label>
                        <input type="password" id="inp-pass" name="pass" class="form-control"/>
                    </div>

                    <div class="form-check d-flex justify-content mb-4">
                        <input class="form-check-input me-2" type="checkbox" name="remember-me" value="remember" id="remember-me" />
                        <label class="form-check-label" for="remember-me">
                            ログインを覚えている
                        </label>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info btn-block">ログイン</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
