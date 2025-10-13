<?php

namespace App\Livewire;

use App\Models\Project;
use App\Services\CocomoCalculatorService;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class Calculator extends Component
{
    public Project $project;

    // Propiedades públicas
    public $kloc;
    public $mode;
    public $salary = 0;
    public $costDrivers = [];
    public array $results = [];
    public array $driversDefinition = [];

    public function mount(Project $project, CocomoCalculatorService $cocomoService)
    {
        $this->project = $project;
        $this->kloc = $project->kloc;
        $this->mode = $project->mode;
        $this->costDrivers = $project->cost_drivers ?? [];
        $this->salary = $project->salary;

        $this->driversDefinition = $cocomoService->getCostDriversDefinition();
        if (empty($this->costDrivers)) {
            foreach (array_keys($this->driversDefinition) as $driverKey) {
                $this->costDrivers[$driverKey] = 'nominal';
            }
        }
        $this->calculate($cocomoService);
    }

    public function updated($propertyName)
    {
        $this->calculate(app(CocomoCalculatorService::class));
    }

    public function calculate(CocomoCalculatorService $cocomoService)
    {
        $this->results = $cocomoService->calculateAllModes(
            (float)$this->kloc,
            $this->costDrivers,
            (float)$this->salary
        );

        if (isset($this->results[$this->mode])) {
            $this->results['main'] = $this->results[$this->mode];
        }
    }

    public function generateReport(CocomoCalculatorService $cocomoService)
    {
        $allModesComparison = $cocomoService->calculateAllModes(
            (float)$this->kloc,
            $this->costDrivers,
            (float)$this->salary
        );
        $mainResults = $allModesComparison[$this->mode];
        $driversDefinition = $cocomoService->getCostDriversDefinition();

        $reportProject = clone $this->project;
        $reportProject->kloc = (float)$this->kloc;
        $reportProject->mode = $this->mode;
        $reportProject->cost_drivers = $this->costDrivers;
        $reportProject->cocomo_model = !empty(array_filter($this->costDrivers, fn($v) => $v !== 'nominal')) ? 'intermedio' : 'basico';

        $data = [
            'project' => $reportProject,
            'results' => [
                'main' => $mainResults,
                'eaf' => $allModesComparison['eaf'],
                'eaf_details' => $allModesComparison['eaf_details']
            ],
            'allModesComparison' => $allModesComparison,
            'driversDefinition' => $driversDefinition,
            'date' => now()->format('d/m/Y'),
            'salary' => (float)$this->salary,
        ];

        $pdf = Pdf::loadView('projects.report', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'reporte-cocomo-' . Str::slug($this->project->project_name) . '.pdf');
    }

    public function render()
    {
        return view('livewire.calculator');
    }
}
