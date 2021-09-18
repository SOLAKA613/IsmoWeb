<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Connect</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        <link rel="stylesheet" href="{{ asset('css/login_signup/style_login.css')}}">
        <link rel="stylesheet" href="{{ asset('css/login_signup/style_erreur.css')}}">
        <link rel="stylesheet" href="{{ asset('css/login_signup/style_input.css')}}">


        <style>
            .alert {
                top: 10%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>
    </head>

<body class="img js-fullheight">

            @if(count($errors) > 0 || Session::has('erreur'))
                <div  class="alert alert-danger alert-dismissible fade show top fixed-top col-md-7 text-center" id="messageErreur" role="alert">
                        <strong>Erreur</strong><br/>
                        {{ Session::get('erreur')  }}
                        <br>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


    <div class="container position-absolute top-50 start-50 translate-middle" style="margin-top: 45px;" id="container">
            <div class="form-container sign-up-container">
                <form id="form" action="/register_Conn" method="POST" onsubmit="return checkInputs()">
                    @csrf
                    <h1 class="title">Create Account</h1>

                    <div class="form-control1 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="admin">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <div class="form-control1 mb-3">
                        <label for="email" style="margin-left: -225px;" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="admin@gmail.com">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <div class="form-control1 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <div class="form-control1 mb-3">
                        <label for="confirm_password" style="margin-right: -66px;" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <button>Sign Up</button>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form id="formConnect"  action="/connect" method="POST" onsubmit="return checkInputsConnect()">
                    @csrf
                    <h1 class="title1">Sign in</h1>
                    <div class="form-control1 mb-3">
                        <label for="usernameConnect" style="margin-left: -185px;" class="form-label label1">Username</label>
                        <input type="text" class="form-control" id="usernameConnect" name="name" placeholder="Admin">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <div class="form-control1 mb-3">
                        <label for="passwordConnect" class="form-label label1">Password</label>
                        <input type="password" class="form-control" id="passwordConnect" name ="password">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="text-right font-semibold mt-4 hover:text-blue-200" style="margin-bottom: 20px;">
                        <a href="{{route('password.request')}}" class="float-right">
                            Forgot Password?
                        </a><br/>
                       <a href="{{route('voyager.login')}}">Login as admin!</a>
                    </div>
                    <button type="submit">Sign In</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
    </div>

    <script src="{{asset('js/login_signup/script.js')}}"></script>
    <script src="{{asset('js/login_signup/codeErreur.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{ asset('js/fontawesome/js/kit.js')}}" crossorigin="anonymous"></script>
</body>

</html>
