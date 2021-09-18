@extends('master')

@section('header')

@endsection

@section('slider')
    <div class="row ">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($posts as $myPost)
                    <div class="carousel-item @if($loop->first) active @endif">
                        <img src="{{ asset('/storage/'.$myPost->image)}}" class="d-block w-100" alt="{{ $myPost->title }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $myPost->title }}</h5>
                            <p>{{ Str::limit($myPost->excerpt, 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        @foreach ($posts as $myPost)

                <div class="col-md-4 my-2">
                    <div class="card" >
                    <img src="{{ asset('/storage/'.$myPost->image)}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $myPost->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted ">{{ $myPost->meta_description}}</h6>
                        <p class="card-text">{{ Str::limit($myPost->excerpt, 100) }}</p>

                    </div>
                    </div>
                </div>

        @endforeach
    </div>


@endsection







