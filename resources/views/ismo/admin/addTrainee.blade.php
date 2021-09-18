@extends('master')

@section('title', 'add Trainer')
@section('head')
    <link rel="stylesheet" href="{{asset('css/login_signup/style_erreur.css')}}">
    <link rel="stylesheet" href="{{asset('css/addStagiaire/style.css')}}">
@endsection

@section('content')

    @if(count($errors) > 0 || Session::has('erreur'))
        <div id="er_message" class="alert alert-danger alert-dismissible fade show top" role="alert">
            @if(Session::has('titleErreur'))
                <strong>{{ session('titleErreur') }}</strong><br/>
            @else
                <strong>Saved Validation Error</strong><br>
            @endif

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

    @if($message = Session::get('success'))
        <div id="su_message" class="alert alert-success alert-dismissible fade show top" role="alert">
            <strong>Success!</strong><br>
            {{ $message }}
        </div>
    @endif

    <div  class="card border-secondary mb-3 formAdd">
        <div class="card-header">
            <h5 class="card-title">Add Trainee</h5>
        </div>
        <form  method="POST" id="form" class="card-body text-secondary"  action="/addTrainee" onsubmit="return checkInputs()">
            @csrf
            <div class="container col-md-8 order-md-1">
                <div class="row">
                    <input type="hidden" name="index" value="@if(!empty($trainee)){{$trainee->id}} @endif" />
                    <div class="form-control1 mb-3">
                        <label for="id" class="form-label">{{ setting('titlecolumne.id') }}</label>
                        <input type="text" name="id"  value="@if(!empty($trainee)){{$trainee->id}} @else {{ old('id') }} @endif" class="form-control" id="id" >
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-control1 mb-3">
                        <label for="first_name" class="form-label">{{setting('titlecolumne.firstName')}}</label>
                        <input type="text" name="first_name" value="@if(!empty($trainee)){{$trainee->first_name}} @else {{ old('first_name') }} @endif" class="form-control" id="first_name">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-control1 mb-3">
                        <label for="last_name" class="form-label">{{setting('titlecolumne.lastName')}}</label>
                        <input type="text" name="last_name" value="@if(!empty($trainee)){{$trainee->last_name}} @else {{ old('last_name') }} @endif" class="form-control" id="last_name">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <div class="form-control1 mb-3" role="group" aria-label="Basic radio toggle button group">
                        <label for="last_name" class="form-label">{{setting('titlecolumne.gender')}}</label>
                        <input type="radio" class="btn-check " name="gender" id="gender1" value="Male"  @if(!empty($trainee)) @if($trainee->gender == "male") checked @endif @elseif(!empty(old('gender'))) @if(old('gender') == "Male") checked @endif @else checked @endif >
                        <label class="btn btn-outline-primary" style="margin-left:15px" for="gender1">Male</label>

                        <input type="radio" class="btn-check"  name="gender" id="gender2" value="Female"  @if(!empty($trainee)) @if($trainee->gender == "female") checked @endif @elseif(!empty(old('gender'))) @if(old('gender') == "Female") checked @endif @endif>
                        <label class="btn btn-outline-primary" for="gender2">Female</label>
                    </div>
                    <div class="form-control1 mb-3">
                        <label for="age" class="form-label">{{setting('titlecolumne.age')}}</label>
                        <input type="text" name="age" value="@if(!empty($trainee)){{$trainee->age}} @else {{ old('age') }} @endif" class="form-control" id="age">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-control1 mb-3">
                        <label for="email" class="form-label">{{setting('titlecolumne.email')}}</label>
                        <input type="email" name="email" value="@if(!empty($trainee)){{$trainee->email}} @else {{ old('email') }} @endif" class="form-control" id="email">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-control1 mb-3">
                        <label for="login" class="form-label">{{setting('titlecolumne.login')}}</label>
                        <input type="text" name="login" value="@if(!empty($account)){{$account->login}} @else {{ old('login') }} @endif" class="form-control" id="login">
                        <i class="fas fa-check-circle" style="margin-top: -15px"></i>
                        <i class="fas fa-exclamation-circle" style="margin-top: -15px"></i>
                        <small>Error message</small>
                    </div>
                    <div class="form-control1 mb-3">
                        <label for="password" class="form-label">{{setting('titlecolumne.password')}}</label>
                        <input type="password" name="password" class="form-control" id="password">
                        <i class="fas fa-check-circle" style="margin-top: -14px"></i>
                        <i class="fas fa-exclamation-circle" style="margin-top: -14px"></i>
                        <small>Error message</small>
                    </div>


                    <button type="submit" class="btn btn-primary btn_submit">Submit</button>
                </div>
            </div>

        </form>
    </div>


@endsection

@push('scripts')
    <script type="text/javascript" src="{{asset('js/addStagiaire/addStagiaire.js')}}"></script>
@endpush

