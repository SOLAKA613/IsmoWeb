<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" href="{{ asset('css/breadcrump/style.css')}}">
        <title>Forgot password</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        <link rel="stylesheet" href="{{ asset('css/login_signup/my-login.css')}}">

    </head>

<body class="img js-fullheight">



        <ul id="breadcrumb" style="margin-top: 160px;">
            <li style="width: 70px;"><a href="/"><i class="fas fa-home"></i></a></li>
            <li style="width: 220px;"><a href="/password/reset"><i class="fas fa-envelope" style="margin-left: -122px;"></i> Email</a></li>
        </ul>


	<section class="my-login-page log">

		<div class="card" >
			<div class="row justify-content-md-center align-items-center">

						<div class="card-body">
							<h4 class="card-title">Forgot Password</h4>
                            <hr/>
							<form method="POST" class="my-login-validation" novalidate="" action="{{ route('password.email') }}">
                                @csrf

                                @if (session('status'))
                                    <div class="alert alert-ssuccess alertSuccess">
                                        {{ session('status') }}
                                    </div>
                                @endif

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Send Password Link
									</button>
								</div>
							</form>
						</div>
					</div>

		</div>
	</section>

    <script src="{{ asset('js/fontawesome/js/kit.js')}}" crossorigin="anonymous"></script>

</body>

</html>
