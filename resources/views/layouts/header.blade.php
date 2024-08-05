<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/main.css') }}" />
    
    @stack('pagewise-links')
    <!-- <script src="{{url('js/main.js')}}"> -->

    <style>
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li class="{{ request()->is('/') ? 'active' : ''}}"><a href="/">Home</a></li>
                <li class="{{ request()->is('holiday-list') ? 'active' : ''}}"><a href="{{ route('holiday-list') }}" >Holiday list</a></li>
                <li class="{{ request()->is('calendar') ? 'active' : ''}}"><a href="{{ route('calendar')}}">calendar</a></li>
               
            </ul>
        </nav>
    </header>

    <main>