<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Style -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">

    {{--<nav>
        <a href="/tasks">Tasks</a>
        <a href="/tags">Tags</a>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    </nav>--}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.navigation')

</head>
    <body class="bg-gray-600 h-screen">
        @yield('content')
    </body>
</html>
