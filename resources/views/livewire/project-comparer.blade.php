<div>
    {{-- SECCIÓN DE SELECCIÓN DE PROYECTOS --}}
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-100 mb-4">Selecciona los proyectos que deseas comparar (hasta 10)</h3>

        @if(count($availableProjects) === 0)
            <p class="text-gray-400">No tienes proyectos creados para comparar. <a href="{{ route('projects.create') }}" class="text-cyan-400 hover:underline">¡Crea uno nuevo!</a></p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($availableProjects as $project)
                    <label
                        for="project-{{ $project->id }}"
                        class="flex items-center p-3 rounded-lg border transition-all duration-200 cursor-pointer
                                {{ in_array($project->id, $selectedProjects) ? 'bg-cyan-600/50 border-cyan-500' : 'bg-slate-800/60 border-slate-700 hover:border-slate-500' }}"
                    >
                        <input
                            id="project-{{ $project->id }}"
                            type="checkbox"
                            wire:model.live="selectedProjects"
                            value="{{ $project->id }}"
                            class="h-4 w-4 rounded bg-slate-900 border-slate-600 text-cyan-600 focus:ring-cyan-500"
                        >
                        <span class="ml-3 text-sm font-medium text-gray-200 truncate">{{ $project->project_name }}</span>
                    </label>
                @endforeach
            </div>
        @endif
    </div>

    {{-- TABLA DE COMPARACIÓN --}}
    @if(!empty($selectedProjects))
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs text-cyan-300 uppercase bg-slate-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 sticky left-0 bg-slate-800 z-10">Métrica</th>
                        @foreach($results as $data)
                            <th scope="col" class="px-6 py-3 text-center">
                                {{ $data['project']->project_name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Salario -->
                    <tr class="border-b border-slate-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-100 whitespace-nowrap sticky left-0 bg-slate-800 z-10">Salario Mensual ($)</th>
                        @foreach($results as $projectId => $data)
                            <td class="px-6 py-4">
                                <x-text-input
                                    type="number"
                                    step="100"
                                    class="w-full text-center"
                                    wire:model.live.debounce.500ms="salaries.{{ $projectId }}"
                                    placeholder="0"
                                />
                            </td>
                        @endforeach
                    </tr>

                    <!-- Modo -->
                    <tr class="bg-slate-800/50 border-b border-slate-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-100 whitespace-nowrap sticky left-0 bg-slate-800/50 z-10">Modo</th>
                        @foreach($results as $data)
                            @php
                                $modes = ['organic' => 'Orgánico', 'semidetached' => 'Semi-acoplado', 'embedded' => 'Empotrado'];
                            @endphp
                            <td class="px-6 py-4 text-center">{{ $modes[$data['project']->mode] ?? ucfirst($data['project']->mode) }}</td>
                        @endforeach
                    </tr>
                    <!-- Fecha de Creación -->
                    <tr class="border-b border-slate-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-100 whitespace-nowrap sticky left-0 bg-slate-800 z-10">Fecha de Creación</th>
                        @foreach($results as $data)
                            <td class="px-6 py-4 text-center">{{ $data['project']->created_at->format('d/m/Y') }}</td>
                        @endforeach
                    </tr>
                    <!-- Factor de Ajuste -->
                    <tr class="bg-slate-800/50 border-b border-slate-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-100 whitespace-nowrap sticky left-0 bg-slate-800/50 z-10">Factor de Ajuste (EAF)</th>
                        @foreach($results as $data)
                            <td class="px-6 py-4 text-center font-mono">{{ number_format($data['calculation']['eaf'] ?? 0, 2) }}</td>
                        @endforeach
                    </tr>

                    <!-- Esfuerzo -->
                    <tr class="border-b border-slate-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-100 whitespace-nowrap sticky left-0 bg-slate-800 z-10">Esfuerzo (PM)</th>
                        @foreach($results as $data)
                            <td class="px-6 py-4 text-center font-mono">{{ $data['calculation']['pm_adjusted'] ?? '0.00' }}</td>
                        @endforeach
                    </tr>
                    <!-- Duración -->
                    <tr class="bg-slate-800/50 border-b border-slate-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-100 whitespace-nowrap sticky left-0 bg-slate-800/50 z-10">Duración (Meses)</th>
                        @foreach($results as $data)
                            <td class="px-6 py-4 text-center font-mono">{{ $data['calculation']['duration'] ?? '0.00' }}</td>
                        @endforeach
                    </tr>
                    <!-- Personal -->
                    <tr class="border-b border-slate-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-100 whitespace-nowrap sticky left-0 bg-slate-800 z-10">Personal Promedio</th>
                        @foreach($results as $data)
                            <td class="px-6 py-4 text-center font-mono">{{ $data['calculation']['avg_staff'] ?? '0.00' }}</td>
                        @endforeach
                    </tr>
                    <!-- Costo Total -->
                    <tr class="">
                        <th scope="row" class="px-6 py-4 font-bold text-cyan-400 whitespace-nowrap sticky left-0 bg-slate-800 z-10">Costo Total (U$D)</th>
                        @foreach($results as $data)
                            <td class="px-6 py-4 text-center font-mono font-bold text-cyan-300">{{ number_format($data['calculation']['total_cost'] ?? 0, 2, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
