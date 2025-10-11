<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-200 leading-tight">
{{ __('Crear Nuevo Proyecto COCOMO I') }}
</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 text-gray-100">

                @if ($errors->any())
                    <div class="mb-4 bg-red-900/50 border border-red-700 text-red-300 px-4 py-3 rounded-lg relative" role="alert">
                        <strong class="font-bold">{{ __('¡Ups! Algo salió mal.') }}</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('projects.store') }}" x-data="{ cocomoModel: '{{ old('cocomo_model', 'basico') }}' }">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre del Proyecto -->
                        <div>
                            <x-input-label for="project_name" :value="__('Nombre del Proyecto')" />
                            <x-text-input id="project_name" class="block mt-1 w-full" type="text" name="project_name" :value="old('project_name')" required autofocus />
                            <x-input-error :messages="$errors->get('project_name')" class="mt-2" />
                        </div>

                        <!-- KLOC -->
                        <div>
                            <x-input-label for="kloc" :value="__('Líneas de Código (en Miles - KLOC)')" />
                            <x-text-input id="kloc" class="block mt-1 w-full" type="number" step="0.01" name="kloc" :value="old('kloc')" required />
                            <x-input-error :messages="$errors->get('kloc')" class="mt-2" />
                        </div>

                        <!-- ¡NUEVO! Campo de Salario Añadido -->
                        <div class="md:col-span-2">
                            <x-input-label for="salary" :value="__('Salario Medio Mensual del Personal ($)')" />
                            <x-text-input id="salary" class="block mt-1 w-full" type="number" step="0.01" name="salary" :value="old('salary', 0)" />
                            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                        </div>

                        <!-- Tipo de Modelo COCOMO -->
                        <div>
                            <x-input-label for="cocomo_model" :value="__('Tipo de Modelo COCOMO')" />
                            <select name="cocomo_model" id="cocomo_model" x-model="cocomoModel" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
                                <option value="basico">Básico (EAF = 1)</option>
                                <option value="intermedio">Intermedio (Calcular EAF)</option>
                            </select>
                            <x-input-error :messages="$errors->get('cocomo_model')" class="mt-2" />
                        </div>

                        <!-- Modo del Proyecto -->
                        <div>
                             <x-input-label for="mode" :value="__('Modo del Proyecto')" />
                             <select name="mode" id="mode" class="block mt-1 w-full border-gray-600 bg-gray-900 text-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
                                 <option value="organic" @if(old('mode') == 'organic') selected @endif>Orgánico</option>
                                 <option value="semidetached" @if(old('mode') == 'semidetached') selected @endif>Semi-acoplado</option>
                                 <option value="embedded" @if(old('mode') == 'embedded') selected @endif>Empotrado</option>
                             </select>
                             <x-input-error :messages="$errors->get('mode')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Sección de Factores de Costo (Aparece condicionalmente) -->
                    <div x-show="cocomoModel === 'intermedio'" x-transition class="mt-8 pt-6 border-t border-slate-700">
                        <h3 class="text-lg font-medium text-gray-100 mb-4">Factores de Costo (Modelo Intermedio)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($driversDefinition as $key => $driver)
                                <div>
                                    <label for="driver-{{$key}}" class="block text-sm font-medium text-gray-300">{{ $driver['name'] }}</label>
                                    <select name="cost_drivers[{{ $key }}]" id="driver-{{$key}}" class="mt-1 block w-full border-gray-600 bg-gray-900 text-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm text-sm">
                                        @foreach($driver['values'] as $valueKey => $multiplier)
                                            <option value="{{ $valueKey }}" {{ old('cost_drivers.'.$key, 'nominal') == $valueKey ? 'selected' : '' }}>
                                                {{ $optionNames[$valueKey] ?? Str::title(str_replace('_', ' ', $valueKey)) }} ({{ number_format($multiplier, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <x-primary-button>
                            {{ __('Guardar Proyecto') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
