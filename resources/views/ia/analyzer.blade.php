<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Analizador de Proyectos con IA
        </h2>
    </x-slot>

    {{-- Estilos personalizados para el resultado del análisis --}}
    <style>
        .analysis-container h3 {
            font-size: 1.25rem; /* 20px */
            font-weight: 600;
            color: #cbd5e1; /* slate-300 */
            margin-top: 1.5rem; /* 24px */
            margin-bottom: 0.75rem; /* 12px */
            border-bottom: 1px solid #475569; /* slate-600 */
            padding-bottom: 0.5rem; /* 8px */
        }
        .analysis-container ul {
            list-style-type: disc;
            padding-left: 1.5rem; /* 24px */
            margin-bottom: 1rem; /* 16px */
        }
        .analysis-container li {
            margin-bottom: 0.5rem; /* 8px */
        }
        .analysis-container p {
            line-height: 1.6;
        }
        .analysis-container strong {
            color: #f1f5f9; /* slate-100 */
        }
        .analysis-attribution {
            text-align: right;
            font-size: 0.875rem; /* 14px */
            font-style: italic;
            color: #94a3b8; /* slate-400 */
            margin-top: 2rem; /* 32px */
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800/50 backdrop-blur-sm overflow-hidden shadow-sm sm:rounded-lg border border-slate-700">
                <div class="p-8 text-gray-300">

                    <form action="{{ route('ia.analyzer.analyze') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="project_id" class="block mb-2 text-sm font-medium text-gray-300">Selecciona un Proyecto para Analizar</label>
                            <select id="project_id" name="project_id" class="bg-slate-900 border border-slate-600 text-gray-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                                <option selected disabled>Elige un proyecto...</option>
                                @forelse ($projects as $project)
                                    <option value="{{ $project->id }}" {{ (isset($selectedProjectId) && $selectedProjectId == $project->id) ? 'selected' : '' }}>
                                        {{ $project->project_name }}
                                    </option>
                                @empty
                                    <option disabled>No hay proyectos disponibles.</option>
                                @endforelse
                            </select>
                        </div>
                        <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Analizar Proyecto</button>
                    </form>

                    {{-- Área de Resultados --}}
                    @if (isset($analysisResult) || isset($error))
                        <div class="mt-8 pt-6 border-t border-slate-700">
                             @if (isset($analysisResult))
                                <div id="analysis-content" class="analysis-container">
                                    {{-- El contenido se renderizará aquí con JavaScript --}}
                                </div>
                                <div class="analysis-attribution">
                                    Informe generado por el motor de IA de OpenAI
                                </div>
                             @elseif (isset($error))
                                <h3 class="text-lg font-semibold mb-4 text-red-400">Error</h3>
                                <p class="text-red-400">{{ $error }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Script para renderizar el resultado de Markdown --}}
    @if (isset($analysisResult))
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const markdownContent = @json($analysisResult);
            if (markdownContent) {
                document.getElementById('analysis-content').innerHTML = marked.parse(markdownContent);
            }
        });
    </script>
    @endif
</x-app-layout>

