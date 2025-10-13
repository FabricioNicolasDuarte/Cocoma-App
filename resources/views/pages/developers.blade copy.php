    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Equipo de Desarrollo') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- yo -->
                    <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-lg p-6 text-center transition-transform transform hover:scale-105 hover:shadow-cyan-500/20 shadow-lg">
                        <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-slate-600 object-cover" src="{{ asset('images/team/duarte.jpg') }}" alt="Foto de Duarte Fabricio">
                        <h3 class="text-2xl font-bold text-white">Duarte Fabricio</h3>
                        <p class="text-cyan-400 font-semibold">Líder del Proyecto</p>
                    </div>

                    <!-- Enzo -->
                    <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-lg p-6 text-center transition-transform transform hover:scale-105 hover:shadow-cyan-500/20 shadow-lg">
                        <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-slate-600 object-cover" src="{{ asset('images/team/ascona.jpg') }}" alt="Foto de Ascona Enzo">
                        <h3 class="text-2xl font-bold text-white">Ascona Enzo</h3>
                        <p class="text-cyan-400 font-semibold">Backend y Testing</p>
                    </div>

                    <!-- Seba -->
                    <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-lg p-6 text-center transition-transform transform hover:scale-105 hover:shadow-cyan-500/20 shadow-lg">
                        <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-slate-600 object-cover" src="{{ asset('images/team/amarilla.jpg') }}" alt="Foto de Amarilla Sebastián">
                        <h3 class="text-2xl font-bold text-white">Amarilla Sebastián</h3>
                        <p class="text-cyan-400 font-semibold">Backend</p>
                    </div>

                </div>
            </div>
        </div>
    </x-app-layout>
