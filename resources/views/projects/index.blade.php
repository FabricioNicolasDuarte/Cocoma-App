<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">


            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Mis Proyectos') }}
            </h2>


            <a href="{{ route('projects.create') }}"
                class="
                    px-4 py-2
                    bg-gray-900
                    text-cyan-400
                    font-bold
                    rounded-md
                    shadow-sm
                    border border-cyan-700
                    hover:bg-black
                    hover:text-cyan-300
                    focus:outline-none
                    focus:ring-2
                    focus:ring-offset-2
                    focus:ring-cyan-500
                    dark:focus:ring-offset-gray-800
                    transition-colors
                    duration-200
                "
            >
                Crear Nuevo Proyecto
            </a>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">

                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-cyan-400 uppercase bg-slate-900 tracking-wider">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nombre del Proyecto</th>
                                    <th scope="col" class="px-6 py-3">KLOC</th>
                                    <th scope="col" class="px-6 py-3">Modo</th>
                                    <th scope="col" class="px-6 py-3">Fecha de Creación</th>
                                    <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $modes = [
                                        'organic' => 'Orgánico',
                                        'semidetached' => 'Semi-acoplado',
                                        'embedded' => 'Empotrado',
                                    ];
                                @endphp
                                @forelse ($projects as $project)
                                    <tr class="border-b border-slate-700 hover:bg-slate-800/50">
                                        <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                                            {{ $project->project_name }}
                                        </th>
                                        <td class="px-6 py-4">{{ $project->kloc }}</td>
                                        <td class="px-6 py-4">{{ $modes[$project->mode] ?? ucfirst($project->mode) }}</td>
                                        <td class="px-6 py-4">{{ $project->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-4">
                                                <!-- Ver/Calcular -->
                                                <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-cyan-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-cyan-400 active:bg-cyan-600 focus:outline-none focus:border-cyan-700 focus:ring ring-cyan-300 disabled:opacity-25 transition ease-in-out duration-150">Ver/Calcular</a>
                                                <!-- Editar -->
                                                <a href="{{ route('projects.edit', $project) }}" class="text-cyan-400 hover:text-cyan-300 transition duration-150 ease-in-out" title="Editar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <!-- Eliminar -->
                                                <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proyecto?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-cyan-500 hover:text-red-400 transition duration-150 ease-in-out" title="Eliminar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-b border-slate-700">
                                        <td colspan="5" class="px-6 py-4 text-center">
                                            No tenés proyectos creados todavía. ¡Creá uno nuevo!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
