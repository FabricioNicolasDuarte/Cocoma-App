<div>
{{-- FORMULARIO DE ENTRADAS --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
{{-- Columna Izquierda: Datos Básicos y Salario --}}
<div class="space-y-4">
<div>
<x-input-label for="kloc" :value="('Kilo Líneas de Código (KLOC)')" />
<x-text-input wire:model.live="kloc" id="kloc" class="block mt-1 w-full" type="number" step="0.1" />
</div>
<div>
<x-input-label for="mode" :value="('Modo del Proyecto')" />
<select wire:model.live="mode" id="mode" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-slate-900/50 dark:text-gray-300 focus:border-cyan-500 dark:focus:border-cyan-600 focus:ring-cyan-500 dark:focus:ring-cyan-600 rounded-md shadow-sm">
<option value="organic">Orgánico</option>
<option value="semidetached">Semi-acoplado</option>
<option value="embedded">Empotrado</option>
</select>
</div>
<div>
<x-input-label for="salary" :value="__('Salario Medio Mensual del Personal ($)')" />
<x-text-input wire:model.live="salary" id="salary" class="block mt-1 w-full" type="number" step="100" />
</div>
</div>

    {{-- Columna Derecha: Tabla de Resultados Principales --}}
    <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-700">
        <h4 class="text-lg font-bold text-gray-100 mb-2">Resultados de la Estimación</h4>
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <span class="font-semibold">Esfuerzo (PM):</span>
                <span class="text-xl font-mono p-1 bg-slate-700 rounded">{{ $results['main']['pm_adjusted'] ?? '0.00' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-semibold">Duración (Meses):</span>
                <span class="text-xl font-mono p-1 bg-slate-700 rounded">{{ $results['main']['duration'] ?? '0.00' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-semibold">Personal Promedio:</span>
                <span class="text-xl font-mono p-1 bg-slate-700 rounded">{{ $results['main']['avg_staff'] ?? '0.00' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-semibold">Costo Total ($):</span>
                <span class="text-xl font-mono p-1 bg-green-800/50 rounded text-green-300 font-bold">{{ number_format($results['main']['total_cost'] ?? 0, 2) }}</span>
            </div>
             <div class="flex justify-between items-center pt-2 border-t border-slate-700 mt-2">
                <span class="font-semibold">Factor de Ajuste (EAF):</span>
                <span class="text-lg font-mono p-1 bg-slate-700 rounded">{{ $results['eaf'] ?? '1.000' }}</span>
            </div>
        </div>
    </div>
</div>

{{-- BLOQUE EXPLICATIVO --}}
<div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 shadow-sm sm:rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-100 mb-4">
        ¿Cómo funciona el Módulo de Análisis de Sensibilidad?
    </h2>
    <p class="text-gray-400 mb-3">
        Este módulo te permite <strong>ajustar y refinar la estimación</strong> según las características específicas de tu proyecto. Cada "Factor de Costo" representa un atributo que puede afectar el resultado final. Experimenta con ellos para ver su impacto en tiempo real.
    </p>
</div>

{{-- MÓDULO DE SENSIBILIDAD (Cost Drivers) --}}
@php
    $optionNames = [
        'very_low'   => 'Muy Bajo',
        'low'        => 'Bajo',
        'nominal'    => 'Nominal',
        'high'       => 'Alto',
        'very_high'  => 'Muy Alto',
        'extra_high' => 'Extra Alto'
    ];
@endphp

<h4 class="text-lg font-bold text-gray-100 mb-4">Factores de Costo (Módulo de Sensibilidad)</h4>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 mb-8">
    @foreach($driversDefinition as $key => $driverData)
        <div>
            <label for="driver-{{$key}}" class="block text-sm font-medium text-gray-300">
                {{ $driverData['name'] }}
                <span class="text-xs font-mono text-gray-500">({{ $results['eaf_details'][$key] ?? '1.00' }})</span>
            </label>
            <select wire:model.live="costDrivers.{{$key}}" id="driver-{{$key}}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-slate-900/50 dark:text-gray-300 focus:border-cyan-500 dark:focus:border-cyan-600 focus:ring-cyan-500 dark:focus:ring-cyan-600 rounded-md shadow-sm text-sm">
                @foreach($driverData['values'] as $value => $multiplier)
                    <option value="{{$value}}">
                        {{-- ¡CORRECCIÓN APLICADA AQUÍ! --}}
                        {{ $optionNames[$value] ?? str_replace('_', ' ', Str::title($value)) }} ({{ number_format($multiplier, 2) }})
                    </option>
                @endforeach
            </select>
        </div>
    @endforeach
</div>

{{-- COMPARACIÓN ENTRE MODOS --}}
<h4 class="text-lg font-bold text-gray-100 mb-4">Comparación entre Modos</h4>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-slate-700">
    <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-slate-700/50 text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Métrica</th>
                <th scope="col" class="px-6 py-3 text-center">Orgánico</th>
                <th scope="col" class="px-6 py-3 text-center">Semi-acoplado</th>
                <th scope="col" class="px-6 py-3 text-center">Empotrado</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b bg-slate-800/50 border-slate-700">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">Esfuerzo (PM)</th>
                <td class="px-6 py-4 text-center font-mono">{{ $results['organic']['pm_adjusted'] ?? '0.00' }}</td>
                <td class="px-6 py-4 text-center font-mono">{{ $results['semidetached']['pm_adjusted'] ?? '0.00' }}</td>
                <td class="px-6 py-4 text-center font-mono">{{ $results['embedded']['pm_adjusted'] ?? '0.00' }}</td>
            </tr>
            <tr class="border-b bg-slate-800/50 border-slate-700">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">Duración (Meses)</th>
                <td class="px-6 py-4 text-center font-mono">{{ $results['organic']['duration'] ?? '0.00' }}</td>
                <td class="px-6 py-4 text-center font-mono">{{ $results['semidetached']['duration'] ?? '0.00' }}</td>
                <td class="px-6 py-4 text-center font-mono">{{ $results['embedded']['duration'] ?? '0.00' }}</td>
            </tr>
            <tr class="border-b bg-slate-800/50 border-slate-700">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">Personal Promedio</th>
                <td class="px-6 py-4 text-center font-mono">{{ $results['organic']['avg_staff'] ?? '0.00' }}</td>
                <td class="px-6 py-4 text-center font-mono">{{ $results['semidetached']['avg_staff'] ?? '0.00' }}</td>
                <td class="px-6 py-4 text-center font-mono">{{ $results['embedded']['avg_staff'] ?? '0.00' }}</td>
            </tr>
             <tr class="bg-slate-800/50">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">Costo Total ($)</th>
                <td class="px-6 py-4 text-center font-mono font-bold">{{ number_format($results['organic']['total_cost'] ?? 0, 2) }}</td>
                <td class="px-6 py-4 text-center font-mono font-bold">{{ number_format($results['semidetached']['total_cost'] ?? 0, 2) }}</td>
                <td class="px-6 py-4 text-center font-mono font-bold">{{ number_format($results['embedded']['total_cost'] ?? 0, 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- BOTÓN PARA GENERAR PDF --}}
<div class="flex justify-end mt-6 border-t border-slate-700 pt-6">
    <button wire:click="generateReport" wire:loading.attr="disabled" wire:loading.class="opacity-50"
            class="inline-flex items-center px-4 py-2 bg-cyan-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-cyan-500 active:bg-cyan-700 focus:outline-none focus:border-cyan-700 focus:ring ring-cyan-300 disabled:opacity-25 transition ease-in-out duration-150">

        <!-- Icono normal -->
        <svg wire:loading.remove wire:target="generateReport" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>

        <!-- Icono de carga (spinner) -->
        <svg wire:loading wire:target="generateReport" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>

        <span wire:loading.remove wire:target="generateReport">Generar Informe (PDF)</span>
        <span wire:loading wire:target="generateReport">Generando...</span>
    </button>
</div>

</div>
