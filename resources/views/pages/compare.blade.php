<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Comparador de Proyectos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900/50 backdrop-blur-sm overflow-hidden shadow-xl sm:rounded-lg border border-slate-700">
                <div class="p-6 text-gray-100">

                    @livewire('project-comparer', ['projects' => $projects])

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

