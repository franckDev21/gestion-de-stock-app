<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            *{
                font-family: 'Roboto', sans-serif;
            }
            [x-cloak] { display: none !important; }
            .bg-primary{
                background-color: #017e84 !important;
                color: #fff !important;
            }
            .bg-secondary{
                background-color: #77717e !important;
                color: #fff !important;
            }
        </style>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- @viteReactRefresh
        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.jsx']) --}}

        
        <link rel="stylesheet" href="{{ asset('build/assets/app.03c58976.css') }}">
        <script defer src="{{ asset('build/assets/app.9cce9989.js') }}"></script>
    </head>
    <body class="font-sans ">

        <!-- notification -->
        <x-flash-message />

        <div class="min-h-screen pb-10" style="background: url('{{ asset('static/img/home-menu-bg-overlay.svg') }}'), linear-gradient(to right bottom, #77717e, #c9a8a9)">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white bg-opacity-80 shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
        {{ $js ?? null }}
    </body>
</html>
