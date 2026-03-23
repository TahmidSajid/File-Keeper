<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$page_title}}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    @include('admin.partisals.header-asset')
</head>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">

        @include('admin.partisals.sidebar')


        <div class="app-container">
            @yield('content')
        </div>


    </div>


    @include('admin.partisals.footer-asset')
    @include('admin.partisals.notify')


</body>

</html>
