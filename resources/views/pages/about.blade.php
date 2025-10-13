<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Sobre Cocoma') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-300 space-y-6 leading-relaxed">

                    <article>
                        <h3 class="text-2xl font-bold text-cyan-400 mb-3">¿Qué es COCOMA?</h3>
                        <p>
                            El nombre de nuestra aplicación, <span class="font-semibold text-white">COCOMA</span>, nace de la fusión de dos conceptos clave: <span class="font-semibold text-white">COCO</span>, en referencia al modelo de estimación <span class="font-semibold text-white">COCOMO</span>, y <span class="font-semibold text-white">MA</span>, por <span class="font-semibold text-white">Management</span> (Gestión). Nuestro objetivo es ofrecer una herramienta de gestión de proyectos centrada en este prestigioso modelo.
                        </p>
                        <p class="mt-2">
                            El modelo <span class="font-semibold text-white">COCOMO</span> (del inglés <span class="font-semibold text-white">COnstructive COst MOdel</span> o Modelo Constructivo de Costos) es uno de los más utilizados y reconocidos en la industria para la estimación de costos de software. Creado por Barry Boehm en 1981, su propósito es ayudar a los gestores a predecir el esfuerzo, el tiempo y los recursos necesarios para desarrollar un producto de software.
                        </p>
                        <p class="mt-2">
                            El modelo se basa en datos históricos de proyectos anteriores y utiliza fórmulas matemáticas para generar estimaciones. La entrada principal del modelo es el tamaño del software, medido en <span class="font-semibold text-white">Kilo Líneas de Código (KLOC)</span>.
                        </p>
                    </article>

                    <hr class="border-slate-700">

                    <article>
                        <h3 class="text-2xl font-bold text-cyan-400 mb-3">Niveles de COCOMO Implementados</h3>
                        <p>
                            El modelo COCOMO I se presenta en tres niveles de complejidad creciente. Nuestra aplicación implementa los dos primeros, que son los más comunes para estimaciones rápidas y ajustadas.
                        </p>

                        <div class="mt-4 pl-4 border-l-4 border-cyan-500 space-y-4">
                            <div>
                                <h4 class="text-xl font-semibold text-white">1. Modelo Básico</h4>
                                <p>
                                    Es la versión más simple y rápida del modelo. Proporciona una estimación inicial basada únicamente en el tamaño del software (KLOC) y el "modo" del proyecto (Orgánico, Semi-acoplado o Empotrado). En este nivel, se asume un entorno de desarrollo ideal, por lo que el Factor de Ajuste de Esfuerzo (EAF) es siempre igual a 1. Es útil para obtener una idea general y rápida del esfuerzo requerido.
                                </p>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white">2. Modelo Intermedio</h4>
                                <p>
                                    Este modelo refina la estimación del Modelo Básico al introducir 15 "Factores de Costo" (Cost Drivers). Estos factores representan atributos específicos del proyecto, del equipo, del producto y de la plataforma. Al ajustar estos factores (por ejemplo, la experiencia del equipo, la complejidad del producto, etc.), se calcula un <span class="font-semibold text-white">Factor de Ajuste de Esfuerzo (EAF)</span> que modifica la estimación inicial, proporcionando un resultado mucho más preciso y adaptado a la realidad del proyecto. Esta es la funcionalidad principal de nuestra calculadora.
                                </p>
                            </div>
                        </div>
                    </article>

                    <hr class="border-slate-700">

                    <article>
                        <h3 class="text-2xl font-bold text-cyan-400 mb-3">Nivel No Implementado: Modelo Detallado</h3>
                        <p>
                            COCOMO I también incluye un tercer nivel, el Modelo Detallado, que ofrece la máxima precisión. A diferencia del Modelo Intermedio, que trata el proyecto como un todo, el Modelo Detallado descompone el proyecto en fases del ciclo de vida del software (como diseño, codificación, pruebas, etc.).
                        </p>
                        <p class="mt-2">
                            En este nivel, el impacto de cada uno de los 15 factores de costo se evalúa de manera individual para cada fase, ya que un mismo factor puede ser muy influyente en una etapa (por ejemplo, la capacidad del analista en la fase de diseño) y poco relevante en otra.
                        </p>
                        <p class="mt-4 bg-slate-800/50 border border-slate-700 rounded-lg p-4 text-slate-300">
                            <span class="font-bold text-white">Nota:</span> La implementación del Modelo Detallado implica una complejidad significativamente mayor tanto en la lógica de cálculo como en la interfaz de usuario. Debido a esto, <span class="font-semibold">su desarrollo no formaba parte de los requerimientos iniciales de este proyecto</span> y, por lo tanto, no se encuentra disponible en la aplicación.
                        </p>
                    </article>

                    <hr class="border-slate-700">

                    <article>
                        <h3 class="text-2xl font-bold text-cyan-400 mb-3">Tecnologías Utilizadas</h3>
                        <p>
                            Esta aplicación fue construida utilizando un conjunto de tecnologías modernas, enfocadas en la eficiencia, la escalabilidad y una experiencia de usuario de alta calidad.
                        </p>
                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                            <!-- Laravel -->
                            <div class="bg-slate-800/50 p-6 rounded-lg border border-slate-700 flex flex-col items-center text-center transition-transform transform hover:scale-105 hover:border-cyan-400">
                                <img src="{{ asset('images/tech/laravel.png') }}" alt="Logo de Laravel" class="h-16 w-auto">
                                <h4 class="mt-4 text-lg font-semibold text-white">Laravel</h4>
                                <p class="text-xs text-cyan-400 font-mono">Versión 12</p>
                                <p class="mt-2 text-sm text-slate-400 flex-grow">Framework de PHP para el backend, gestionando la lógica de negocio, rutas, autenticación y la base de datos.</p>
                                <a href="https://laravel.com/docs/12.x" target="_blank" class="mt-4 text-xs font-semibold text-slate-400 hover:text-white underline">Ver Documentación &rarr;</a>
                            </div>

                            <!-- Livewire -->
                            <div class="bg-slate-800/50 p-6 rounded-lg border border-slate-700 flex flex-col items-center text-center transition-transform transform hover:scale-105 hover:border-cyan-400">
                                <img src="{{ asset('images/tech/livewire.png') }}" alt="Logo de Livewire" class="h-16 w-auto">
                                <h4 class="mt-4 text-lg font-semibold text-white">Livewire</h4>
                                <p class="text-xs text-cyan-400 font-mono">Versión 3</p>
                                <p class="mt-2 text-sm text-slate-400 flex-grow">Framework full-stack que permite crear interfaces dinámicas y reactivas, como la calculadora, escribiendo PHP.</p>
                                <a href="https://livewire.laravel.com/docs" target="_blank" class="mt-4 text-xs font-semibold text-slate-400 hover:text-white underline">Ver Documentación &rarr;</a>
                            </div>

                            <!-- Alpine.js -->
                            <div class="bg-slate-800/50 p-6 rounded-lg border border-slate-700 flex flex-col items-center text-center transition-transform transform hover:scale-105 hover:border-cyan-400">
                               <img src="{{ asset('images/tech/alpine.png') }}" alt="Logo de Alpine.js" class="h-16 w-auto">
                                <h4 class="mt-4 text-lg font-semibold text-white">Alpine.js</h4>
                                <p class="text-xs text-cyan-400 font-mono">Versión 3</p>
                                <p class="mt-2 text-sm text-slate-400 flex-grow">Framework de JavaScript minimalista para potenciar la interactividad en el cliente, como mostrar/ocultar elementos.</p>
                                <a href="https://alpinejs.dev/start-here" target="_blank" class="mt-4 text-xs font-semibold text-slate-400 hover:text-white underline">Ver Documentación &rarr;</a>
                            </div>

                            <!-- Tailwind CSS  -->
                            <div class="bg-slate-800/50 p-6 rounded-lg border border-slate-700 flex flex-col items-center text-center transition-transform transform hover:scale-105 hover:border-cyan-400">
                                <img src="{{ asset('images/tech/tailwind.png') }}" alt="Logo de Tailwind CSS" class="h-16 w-auto">
                                <h4 class="mt-4 text-lg font-semibold text-white">Tailwind CSS</h4>
                                <p class="text-xs text-cyan-400 font-mono">Versión 3</p>
                                <p class="mt-2 text-sm text-slate-400 flex-grow">Framework de CSS "utility-first" que ha permitido construir todo el diseño visual personalizado de la aplicación.</p>
                                <a href="https://tailwindcss.com/docs" target="_blank" class="mt-4 text-xs font-semibold text-slate-400 hover:text-white underline">Ver Documentación &rarr;</a>
                            </div>

                            <!-- MySQL -->
                            <div class="bg-slate-800/50 p-6 rounded-lg border border-slate-700 flex flex-col items-center text-center transition-transform transform hover:scale-105 hover:border-cyan-400">
                                <img src="{{ asset('images/tech/mysql.png') }}" alt="Logo de MySQL" class="h-16 w-auto">
                                <h4 class="mt-4 text-lg font-semibold text-white">MySQL</h4>
                                <p class="text-xs text-cyan-400 font-mono">Versión 8.0</p>
                                <p class="mt-2 text-sm text-slate-400 flex-grow">Sistema de gestión de bases de datos relacional donde se almacenan todos los datos de usuarios y proyectos.</p>
                                <a href="https://dev.mysql.com/doc/" target="_blank" class="mt-4 text-xs font-semibold text-slate-400 hover:text-white underline">Ver Documentación &rarr;</a>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
