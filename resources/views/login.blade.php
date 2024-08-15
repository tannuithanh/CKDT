<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng nhập</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: #666666;">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form action="" method="POST" class="login100-form validate-form">
                    @csrf
                    <div class="login-header" style="text-align: center;">
                        <img src="{{ asset('assets/img/logo.png') }}" style="height: 50px;" alt="Logo"> <!-- Thay đổi đường dẫn hình ảnh tại đây -->
                        <span class="login100-form-title p-b-43">
                            CHỮ KÝ ĐIỆN TỬ
                        </span>
                    </div>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="msnv">
						<span class="focus-input100"></span>
						<span class="label-input100">Mã số nhân viên</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pass">
						<span class="focus-input100"></span>
						<span class="label-input100">Mật khẩu</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Đăng nhập
						</button>
					</div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3" style="text-align: center;">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                        </div>
                    @endif
				</form>

				<div class="login100-more" style="background-image: url('{{asset('assets/img/BG1.jpg')}}');">
				</div>
			</div>
		</div>
	</div>
    <script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
