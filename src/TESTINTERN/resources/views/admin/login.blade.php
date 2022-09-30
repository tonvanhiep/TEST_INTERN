<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Đăng nhập quản lý</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anek+Latin:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">


  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/register.css')}}">
</head>
<body style="background-image: url('https://img.freepik.com/free-photo/hand-painted-watercolor-background-with-sky-clouds-shape_24972-1095.jpg?w=1500'); background-attachment:fixed;">
    <section class="bg-image" style="margin: auto;">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <a href="{{route('home')}}" class="fw-bold text-body"><< Trở về trang chủ</a>

                                <h2 class="text-uppercase text-center mb-4 mt-4">Đăng nhập</h2>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{route('admin.p_loginManagement')}}">
                                    @csrf
                                    <div class="form-outline mb-3">
                                        <label class="form-label" for="inp-email">Email *</label>
                                        <input type="email" id="inp-email" name="email" class="form-control"/>
                                    </div>

                                    <div class="form-outline mb-3">
                                        <label class="form-label" for="inp-pass">Mật khẩu *</label>
                                        <input type="password" id="inp-pass" name="pass" class="form-control"/>
                                    </div>

                                    <div class="form-check d-flex justify-content mb-4">
                                        <input class="form-check-input me-2" type="checkbox" name="remember-me" value="remember" id="remember-me" />
                                        <label class="form-check-label" for="remember-me">
                                            Lưu đăng nhập
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-info btn-block">Đăng nhập</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
