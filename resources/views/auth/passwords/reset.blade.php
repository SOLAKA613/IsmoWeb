<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Forgot password</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        <link rel="stylesheet" href="{{ asset('css/login_signup/my-login.css')}}">
        <link rel="stylesheet" href="{{ asset('css/breadcrump/style.css')}}">
    </head>

<body class="img js-fullheight">

    <ul id="breadcrumb" style="margin-top: 300px;">
        <li style="width: 70px;"><a href="/"><i class="fas fa-home"></i></a></li>
        <li style="width: 220px;"><a href="#"><i class="fas fa-envelope" style="margin-left: -122px;"></i> Email</a></li>
    </ul>


	<section class="my-login-page log position-relative">
		<div class="card">
			<div class="row justify-content-md-center align-items-center">

						<div class="card-body">
							<h4 class="card-title">Reset Password</h4>
                            <hr>
							<form method="POST" class="my-login-validation" novalidate="" action="{{ route('password.update') }}" novalidate>
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">
								<div class="form-group">
									<label for="email" style="margin-top: 5px;">Email</label>
									<input id="email" type="email" class="form-control" name="email" placeholder="Email address" value="{{ $email ?? old('email') }}" required>
                                    <span class="text-danger">@error('email'){{$message}} @enderror</span>
								</div>
								<div class="form-group">
									<label for="password">New Password</label>
									<input id="password" type="password" class="form-control" name="password" placeholder="Enter new password" required>
                                    <span class="text-danger">@error('password'){{$message}}@enderror</span>
								</div>
								<div class="form-group">
									<label for="password-confirm">Confirm Password</label>
									<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Enter confirm password" required>
                                    <span class="text-danger">@error('password_confirmation'){{$message}} @enderror</span>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Reset Password
									</button>
								</div>
							</form>
						</div>

			</div>
		</div>
	</section>


    <script src="{{asset('js/selectChoice/selectChoice.js')}}"></script>
    <script src="{{ asset('js/fontawesome/js/kit.js')}}" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>
