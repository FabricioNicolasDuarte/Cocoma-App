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

    // Almacena los salarios para cada proyecto seleccionado
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

    public function updatedSelectedProjects()
    {
        $this->recalculate();
    }

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
            $salary = (float)($this->salaries[$project->id] ?? $project->salary);
            $this->salaries[$project->id] = $salary;

            $costDrivers = $project->cost_drivers ?? [];
            $calculation = $this->cocomoService->calculate($project->mode, $project->kloc, $costDrivers, $salary);


            $this->results[$project->id] = [
                'project' => $project,
                'calculation' => $calculation,
            ];

        }
    }

    public function render()
    {
        return view('livewire.project-comparer');
    }
}
