@extends('master')

@section('title', 'table of data')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/TableDataTrainer/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/addTrainer/style.css')}}">
@endsection

@section('content')

    @if(count($errors) > 0 || Session::has('erreur'))
        <div id="er_message" class="alert alert-danger alert-dismissible fade show top" role="alert">
            @if(Session::has('titleErreur'))
                <strong>{{ session('titleErreur') }}</strong><br/>
            @else
                <strong>Selection error</strong><br>
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
            <h5 class="card-title">Add Trainer</h5>
        </div>
        <form action = "/addUpdateTrainer" method="POST" onsubmit="return myFunction()" style = "margin-top:150px" id = "DataTrainer" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="container col-md-8 order-md-1 cont">
                <div class="row">

                    <input type="hidden" name="index" value="@if(!empty($trainer)){{$trainer->id}} @endif" />
                    <div class="row ">

                        <div class="input-group mb-3">
                            <span class="input-group-text">{{setting('admin.timeAbsence')}}</span>
                            <input type="datetime-local" aria-label="First time" class="form-control">
                            <input type="datetime-local" aria-label="Last time" class="form-control">
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                First and last time cannot be blank.
                            </div>
                        </div>
                        <div class="col-md">
                            <label for="first_name" class="form-label">{{setting('titlecolumne.firstName')}}</label>
                            <input type="text" name="first_name" value="@if(!empty($trainer)){{$trainer->first_name}} @else{{ old('first_name') }}@endif" class="form-control" id="first_name" required>
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                First name cannot be blank.
                            </div>
                        </div>
                        <div class="col-md">
                            <label for="first_name" class="form-label">{{setting('titlecolumne.firstName')}}</label>
                            <input type="text" name="first_name" value="@if(!empty($trainer)){{$trainer->first_name}} @else{{ old('first_name') }}@endif" class="form-control" id="first_name" required>
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                First name cannot be blank.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end btn_submit">
                        <button id="submit" type="submit" type="button" class="btn btn-primary d-flex justify-content-end" >Validate</button>
                    </div>

                </div>
            </div>
        </form>
    </div>


@endsection
@push('scripts')
<script src="{{asset('js/modalTrainer/addSelect.js')}}"></script>

    <script src="{{asset('js/selectChoice/selectChoice.js')}}"></script>
    <script src="{{asset('js/modalTrainer/validationUploadFile.js')}}"></script>
@endpush

