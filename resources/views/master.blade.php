@if(!empty(session('user')))
    <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta name="description" content="@yield('title')">
            <meta name="keywords" content="">
            <meta name="author" content="Slimane Karbouze">
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            <meta charset="UTF-8">
            <title>@yield('title')</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="{{ asset('css/nav/style.css')}}">
            <link rel="stylesheet" href="{{ asset('css/app.css')}}">
            <link rel="stylesheet" id="theme_link" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.0.1/'.setting('site.theme').'/bootstrap.min.css') }}" />
            <link rel="stylesheet" href="{{ asset('css/style.css')}}">
        <!--    <link rel="stylesheet" href="('css/w3schools/w3schools.css')}}"> -->
            <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel="stylesheet">
            @yield('head')
        </head>
    <body id="body-pd">

        <div style="margin-top: 150px; margin-bottom:50px;">{{session('user')}}</div>
        <div class="wrapper d-flex align-items-stretch">

            @include('partials.navbar')

            <div class="container mt-4">
                @yield('slider')
                @yield('content')
            </div>

        </div>

        @include('partials.Footer.footer')






        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/nav/popper.js')}}"></script>
        <script src="{{asset('js/nav/main.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <!-- Latest compiled and minified JavaScript stack-->
        <script src="{{ asset('js/fontawesome/js/kit.js')}}" crossorigin="anonymous"></script>

        @stack('scripts')
    </body>

    </html>
@else

    @php return redirect('/'); @endphp

@endif
