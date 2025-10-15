<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\AIAnalysisService;
use Illuminate\Http\Request;
use Exception;

class AIAnalysisController extends Controller
{
    /**
     * Muestra la vista del analizador con la lista de proyectos.
     */
    public function index()
    {
        // Obtiene todos los proyectos para rellenar el menú desplegable.
        $projects = Project::select('id', 'project_name')->get();

        // Carga la vista y le pasa la lista de proyectos.
        return view('ia.analyzer', [
            'projects' => $projects,
        ]);
    }

    /**
     * Procesa la solicitud de análisis del proyecto seleccionado.
     */
    public function analyze(Request $request, AIAnalysisService $aiService)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        $projectId = $request->input('project_id');
        $analysisResult = null;
        $error = null;

        try {
            $analysisResult = $aiService->analyzeProject($projectId);
        } catch (Exception $e) {
            $error = 'Hubo un error al comunicarse con el servicio de IA. Por favor, revisa tu clave API y la configuración. Detalles: ' . $e->getMessage();
        }

        $projects = Project::select('id', 'project_name')->get();

        return view('ia.analyzer', [
            'projects' => $projects,
            'selectedProjectId' => $projectId,
            'analysisResult' => $analysisResult,
            'error' => $error,
        ]);
    }
}
