<?php

namespace App\Livewire;

use App\Models\Project;
use App\Services\CocomoCalculatorService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectComparer extends Component
{
    // Todos los proyectos disponibles del usuario
    public Collection $availableProjects;

    // IDs de los proyectos seleccionados para comparar
    public array $selectedProjects = [];

    // Almacena los salarios para cada proyecto seleccionado (ahora se pre-cargará)
    public array $salaries = [];

    // Almacena los resultados de los cálculos
    public array $results = [];

    protected $cocomoService;

    public function boot(CocomoCalculatorService $cocomoService)
    {
        $this->cocomoService = $cocomoService;
    }

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->availableProjects = $user ? $user->projects : collect();
    }

    // Hook que se ejecuta cuando la propiedad $selectedProjects cambia.
    public function updatedSelectedProjects()
    {
        $this->recalculate();
    }

    // Hook que se ejecuta cuando la propiedad $salaries cambia.
    public function updatedSalaries()
    {
        $this->recalculate();
    }

    public function recalculate()
    {
        $this->results = [];
        if (empty($this->selectedProjects)) {
            return;
        }

        $projectsToCompare = $this->availableProjects->whereIn('id', $this->selectedProjects);

        foreach ($projectsToCompare as $project) {
            // --- ¡CORRECCIÓN CLAVE! ---
            // 1. Usamos el salario del input si el usuario ha escrito algo.
            // 2. Si no, usamos el salario guardado en el proyecto ($project->salary).
            $salary = (float)($this->salaries[$project->id] ?? $project->salary);

            // 3. Actualizamos el array $salaries para que el input en la vista muestre
            //    el valor correcto (ya sea el guardado o el que el usuario está escribiendo).
            $this->salaries[$project->id] = $salary;

            $costDrivers = $project->cost_drivers ?? [];

            // 4. Calculamos los resultados con el salario correcto.
            $calculation = $this->cocomoService->calculate($project->mode, $project->kloc, $costDrivers, $salary);

            $this->results[$project->id] = $calculation;
        }
    }

    public function render()
    {
        return view('livewire.project-comparer');
    }
}

