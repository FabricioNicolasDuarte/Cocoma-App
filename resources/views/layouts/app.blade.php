<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cocoma') }}</title>

        <!-- Fuentes que usamos-->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/background.png') }}')">
            @include('layouts.navigation')


            @isset($header)
                <header class="bg-slate-900/50 backdrop-blur-sm shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset


            <main>
                {{ $slot }}
            </main>
        </div>
        <x-back-button />



        <footer class="fixed bottom-0 left-0 w-full bg-slate-900/80 backdrop-blur-sm text-center p-2 text-xs text-gray-400 border-t border-slate-700">
            <p>Proyecto hecho para la materia Gestión de Desarrollo de Software | Universidad Tecnológica Nacional | Facultad Regional de Resistencia | Desarroladores: Duarte Fabricio, Ascona Enzo y Amarilla Sebastián.</p>
        </footer>

    </body>
</html>
