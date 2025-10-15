<?php

namespace App\Services;

use App\Models\Project;
use OpenAI\Laravel\Facades\OpenAI;
use Exception;

class AIAnalysisService
{
    public function analyzeProject(int $projectId): string
    {
        $project = Project::findOrFail($projectId);
        $prompt = $this->buildPrompt($project);

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o', // Usamos un modelo más avanzado para mayor calidad de análisis
                'messages' => [
                    // Instrucción del sistema: Define el rol y la pericia de la IA.
                    ['role' => 'system', 'content' => 'Actúa como un Gerente de Proyectos de Software Senior y experto en el modelo de estimación COCOMO II. Tu análisis debe ser profesional, cuantitativo cuando sea posible, y orientado a la toma de decisiones gerenciales. La respuesta debe estar exclusivamente en formato Markdown, bien estructurada y lista para ser presentada en un informe.'],
                    // Prompt del usuario: Contiene los datos específicos del proyecto a analizar.
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            return $result->choices[0]->message->content;

        } catch (Exception $e) {
            // Manejo de errores en caso de que la API falle
            return "### Error en el Análisis\n\nNo se pudo establecer comunicación con el servicio de IA. Por favor, verifica la configuración de la API Key y la conexión a internet. Detalles del error: " . $e->getMessage();
        }
    }

    private function buildPrompt(Project $project): string
    {
        $prompt = "## Análisis Ejecutivo de Proyecto de Software\n\n";
        $prompt .= "Por favor, realiza un análisis exhaustivo del siguiente proyecto basado en sus métricas COCOMO II. La estructura del informe debe ser la siguiente:\n\n";

        $prompt .= "### 1. Resumen de Datos del Proyecto\n";
        $prompt .= "- **Nombre:** " . $project->project_name . "\n";
        $prompt .= "- **Modelo COCOMO:** " . $project->cocomo_model . "\n";
        $prompt .= "- **Modo:** " . $project->mode . "\n";
        $prompt .= "- **KLOC (Miles de Líneas de Código):** " . $project->kloc . "\n";
        $prompt .= "- **Salario Promedio del Equipo:** $" . number_format($project->salary, 2) . "\n\n";

        $prompt .= "### 2. Análisis de Impulsores de Costo (Cost Drivers)\n";
        $prompt .= "Evalúa los siguientes impulsores de costo, identificando fortalezas (valores bajos/nominales que reducen costos/riesgos) y debilidades (valores altos/muy altos que aumentan costos/riesgos):\n\n";

        $costDrivers = $project->cost_drivers;
        if (is_array($costDrivers) && !empty($costDrivers)) {
            foreach ($costDrivers as $driver => $value) {
                $prompt .= "- **" . ucfirst(str_replace('_', ' ', $driver)) . ":** " . $value . "\n";
            }
        } else {
            $prompt .= "- No se proporcionaron impulsores de costo específicos.\n";
        }

        $prompt .= "\n### 3. Diagnóstico General y Puntos Críticos\n";
        $prompt .= "Basado en los datos, proporciona un diagnóstico profesional. Identifica los 2-3 impulsores de costo más críticos (positivos o negativos) y explica su impacto potencial en el cronograma, presupuesto y calidad del proyecto.\n\n";

        $prompt .= "### 4. Plan de Acción y Recomendaciones Estratégicas\n";
        $prompt .= "Genera una lista de 3 a 5 recomendaciones accionables y priorizadas. Para cada recomendación, especifica:\n";
        $prompt .= "- **Acción:** ¿Qué se debe hacer?\n";
        $prompt .= "- **Justificación:** ¿Por qué es importante, basado en los datos?\n";
        $prompt .= "- **Impacto Esperado:** ¿Qué mejora se espera (ej. reducción de riesgo, optimización de costos, mejora de calidad)?\n\n";

        $prompt .= "### 5. Conclusión Gerencial\n";
        $prompt .= "Finaliza con un párrafo de conclusión dirigido a la gerencia, resumiendo el estado del proyecto y el retorno de inversión esperado si se implementan las acciones recomendadas.";

        return $prompt;
    }
}

