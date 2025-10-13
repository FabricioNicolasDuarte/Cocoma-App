<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Cocoma') }}</title>


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        @vite(['resources/css/app.css', 'resources/js/app.js'])


        <style>
            #background-video {
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                z-index: -100;
                object-fit: cover;
            }
        </style>
    </head>
    <body class="antialiased font-sans">

        <video autoplay muted loop id="background-video">
            <source src="{{ asset('videos/videobackground.mp4') }}" type="video/mp4">
            Tu navegador no soporta videos HTML5.
        </video>

        <div class="min-h-screen flex flex-col items-center justify-center p-6">


            <div class="w-full max-w-md text-center bg-slate-900/50 backdrop-blur-sm p-8 rounded-xl shadow-2xl border border-slate-700/50">


                <div class="mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Cocoma" class="mx-auto h-24 w-auto">
                </div>


                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Bienvenido a Cocoma
                </h1>
                <p class="text-lg text-gray-300 mb-8">
                    Tu herramienta para la gestión y estimación de proyectos de software.
                </p>


                <div class="mb-6">
                    <a href="{{ route('login') }}" class="inline-block w-full px-8 py-4 bg-cyan-500 border border-transparent rounded-lg font-semibold text-lg text-white uppercase tracking-widest hover:bg-cyan-400 focus:outline-none focus:border-cyan-700 focus:ring focus:ring-cyan-200 active:bg-cyan-600 disabled:opacity-25 transition-transform transform hover:scale-105 duration-300">
                        Iniciar
                    </a>
                </div>


                <div>
                    <p class="text-sm text-gray-300">
                        ¿No tienes una cuenta?
                        <a href="{{ route('register') }}" class="font-medium text-cyan-400 hover:text-cyan-300 underline">
                            Regístrate aquí
                        </a>
                    </p>
                </div>

            </div>

        </div>
    </body>
</html>
