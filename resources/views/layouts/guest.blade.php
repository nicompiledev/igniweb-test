<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Book Reservation App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="min-height: 100vh; background-image: url('{{ asset('images/library-background.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" style="min-height: 100vh; background-image: url('{{ asset('images/library-background.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
            <div>
                <a href="/">
                    <x-application-logo class="border-4 border-white text-gray-800 text-6xl p-1 hover:shadow-lg hover:scale-105 transition duration-300" />


                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" >
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
