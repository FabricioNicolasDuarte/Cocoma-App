<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\CocomoCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $projects = $user->projects()->latest()->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CocomoCalculatorService $cocomoService)
    {
        $driversDefinition = $cocomoService->getCostDriversDefinition();
        $optionNames = [
            'very_low'   => 'Muy Bajo',
            'low'        => 'Bajo',
            'nominal'    => 'Nominal',
            'high'       => 'Alto',
            'very_high'  => 'Muy Alto',
            'extra_high' => 'Extra Alto'
        ];
        return view('projects.create', compact('driversDefinition', 'optionNames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ¡CORRECCIÓN! Se añade 'salary' a las reglas de validación.
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'kloc' => 'required|numeric|min:0.01',
            'salary' => 'nullable|numeric|min:0', // Puede ser opcional, numérico y no negativo.
            'cocomo_model' => 'required|in:basico,intermedio',
            'mode' => 'required|in:organic,semidetached,embedded',
            'cost_drivers' => 'sometimes|required_if:cocomo_model,intermedio|array',
        ]);

        if ($validated['cocomo_model'] === 'basico') {
            $validated['cost_drivers'] = null;
        }

        // ¡CORRECCIÓN! Si el salario no se envía, se establece en 0 por defecto.
        if (!isset($validated['salary'])) {
            $validated['salary'] = 0;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->projects()->create($validated);

        return redirect()->route('projects.index')->with('success', 'Proyecto creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        Gate::authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        Gate::authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        Gate::authorize('update', $project);
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
        ]);
        $project->update($validated);
        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado con éxito.');
    }

    // El método generateReport no necesita cambios.
    public function generateReport(Project $project, Request $request, CocomoCalculatorService $cocomoService)
    {
        Gate::authorize('view', $project);

        $kloc = (float)$request->input('kloc', $project->kloc);
        $mode = $request->input('mode', $project->mode);
        $salary = (float)$request->input('salary', $project->salary); // Ahora puede leer el salario del proyecto
        $costDrivers = json_decode($request->input('cost_drivers', '[]'), true);

        $allModesComparison = $cocomoService->calculateAllModes($kloc, $costDrivers, $salary);
        $driversDefinition = $cocomoService->getCostDriversDefinition();

        $project->kloc = $kloc;
        $project->mode = $mode;
        $project->cocomo_model = !empty($costDrivers) && !empty(array_filter($costDrivers, fn($v) => $v !== 'nominal')) ? 'intermedio' : 'basico';
        $project->cost_drivers = $costDrivers;

        $mainResults = $allModesComparison[$mode];

        $data = [
            'project' => $project,
            'results' => [
                'main' => $mainResults,
                'eaf' => $allModesComparison['eaf'],
                'eaf_details' => $allModesComparison['eaf_details']
            ],
            'allModesComparison' => $allModesComparison,
            'driversDefinition' => $driversDefinition,
            'date' => now()->format('d/m/Y'),
            'salary' => $salary,
        ];

        $pdf = Pdf::loadView('projects.report', $data);
        return $pdf->download('reporte-cocomo-' . Str::slug($project->project_name) . '.pdf');
    }
}

