<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Proyecto: ') . $project->project_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del Proyecto -->
                        <div>
                            <x-input-label for="project_name" :value="__('Nombre del Proyecto')" />
                            <x-text-input id="project_name" class="block mt-1 w-full" type="text" name="project_name" :value="old('project_name', $project->project_name)" required autofocus />
                        </div>

                        <!-- KLOC -->
                        <div class="mt-4">
                            <x-input-label for="kloc" :value="__('Kilo Líneas de Código (KLOC)')" />
                            <x-text-input id="kloc" class="block mt-1 w-full" type="number" step="0.01" name="kloc" :value="old('kloc', $project->kloc)" required />
                        </div>

                        <!-- Modo del Proyecto -->
                        <div class="mt-4">
                            <x-input-label for="mode" :value="__('Modo del Proyecto')" />
                            <select name="mode" id="mode" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="organic" {{ old('mode', $project->mode) == 'organic' ? 'selected' : '' }}>Orgánico</option>
                                <option value="semidetached" {{ old('mode', $project->mode) == 'semidetached' ? 'selected' : '' }}>Semi-acoplado</option>
                                <option value="embedded" {{ old('mode', $project->mode) == 'embedded' ? 'selected' : '' }}>Empotrado</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                             <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Proyecto') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
