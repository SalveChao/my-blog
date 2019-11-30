<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Myblog') }}</title> -->
    @yield('title')

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    @yield('css')



</head>
<body>
    <div id="content" style="min-height:100vh">
    <div id="app">
        @include('partials/nav')
        <main class="py-3">
            <div class="container-fluid">
                @if(session()->has('error'))
              　<div class="alert alert-success">{{ session()->get('error') }}</div>
                @endif

                @if(session()->has('success'))
                <div class="alert alert-success">{{ session()->get('success') }}</div>
                @endif
                <div class="row">
                   　<div class="col-8">
                        @yield('content')
                     </div>
                     <div class="col-3">
                        @include('side_bar.rightside')
                     </div>
          　    </div>

            </div>
        </main>
    </div>
    </div>
    @include('footer')
    <!-- Scripts -->
    <script src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
