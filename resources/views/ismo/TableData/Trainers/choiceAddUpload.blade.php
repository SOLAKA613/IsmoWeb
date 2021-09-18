@extends('master')

@section('title', 'table of data')
@section('head')
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/choiceUpload/choiceUpload.css')}}"/>
@endsection

@section('content')
    <section class="wrapper">
        <div class="container position-relative">

            <div class="row">
                <div class="col-sm-4" style="margin-left: 150px">
                    <div onclick="location.href='{{ url('/import_excelTrainers') }}'" class="card text-white card-has-bg click-col" style="background-image:url('{{ asset('storage/images/excel.png')}}');">
                        <div class="card-img-overlay d-flex flex-column">
                            <div class="card-body">
                                <small class="card-meta mb-2">Add List of trainers</small>
                                <h4 class="card-title mt-0 "><a class="text-white" herf="#">Import an excel file containing a list of trainers to the database</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div onclick="location.href='{{ url('/formTrainer') }}'" class="card text-white card-has-bg click-col" style="background-image:url('https://source.unsplash.com/600x900/?tree,nature');">
                        <div class="card-img-overlay d-flex flex-column">
                            <div class="card-body">
                                <small class="card-meta mb-2">Add One Trainer</small>
                                <h4 class="card-title mt-0 "><a class="text-white" herf="#">Add the required information for one trainer</a></h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')

@endpush
