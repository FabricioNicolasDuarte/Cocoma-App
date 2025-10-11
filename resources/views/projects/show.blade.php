<x-app-layout>
<x-slot name="header">
<div class="flex justify-between items-center">
<h2 class="font-semibold text-xl text-white leading-tight">
{{ __('Detalles del Proyecto: ') }} {{ $project->project_name }}
</h2>
{{-- El botón se ha eliminado de aquí para evitar todos los errores --}}
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-slate-900/50 backdrop-blur-sm overflow-hidden shadow-xl sm:rounded-lg border border-slate-700">
            <div class="p-6 text-gray-100">
                {{-- Este componente ahora contendrá su propio botón y toda la lógica --}}
                @livewire('calculator', ['project' => $project])
            </div>
        </div>
    </div>
</div>

</x-app-layout>
