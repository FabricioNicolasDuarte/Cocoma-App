<?php

namespace App\Services;

class CocomoCalculatorService
{

    private const CONSTANTS = [
        'organic' => ['a' => 2.4, 'b' => 1.05, 'c' => 2.5, 'd' => 0.38],
        'semidetached' => ['a' => 3.0, 'b' => 1.12, 'c' => 2.5, 'd' => 0.35],
        'embedded' => ['a' => 3.6, 'b' => 1.20, 'c' => 2.5, 'd' => 0.32],
    ];


    private const COST_DRIVERS_DEFINITION = [
        'rely' => [
            'name' => 'Fiabilidad Requerida (RELY)',
            'values' => ['very_low' => 0.75, 'low' => 0.88, 'nominal' => 1.00, 'high' => 1.15, 'very_high' => 1.40]
        ],
        'data' => [
            'name' => 'Tamaño de la Base de Datos (DATA)',
            'values' => ['low' => 0.94, 'nominal' => 1.00, 'high' => 1.08, 'very_high' => 1.16]
        ],
        'cplx' => [
            'name' => 'Complejidad del Producto (CPLX)',
            'values' => ['very_low' => 0.70, 'low' => 0.85, 'nominal' => 1.00, 'high' => 1.15, 'very_high' => 1.30, 'extra_high' => 1.65]
        ],
        'time' => [
            'name' => 'Restricciones de Tiempo de Ejecución (TIME)',
            'values' => ['nominal' => 1.00, 'high' => 1.11, 'very_high' => 1.30, 'extra_high' => 1.66]
        ],
        'stor' => [
            'name' => 'Restricciones de Memoria (STOR)',
            'values' => ['nominal' => 1.00, 'high' => 1.06, 'very_high' => 1.21, 'extra_high' => 1.56]
        ],
        'virt' => [
            'name' => 'Volatilidad del Entorno Virtual (VIRT)',
            'values' => ['very_low' => 0.87, 'low' => 0.94, 'nominal' => 1.00, 'high' => 1.10, 'very_high' => 1.15]
        ],
        'turn' => [
            'name' => 'Tiempo de Respuesta (TURN)',
            'values' => ['low' => 0.87, 'nominal' => 1.00, 'high' => 1.07, 'very_high' => 1.15]
        ],
        'acap' => [
            'name' => 'Capacidad del Analista (ACAP)',
            'values' => ['very_low' => 1.46, 'low' => 1.19, 'nominal' => 1.00, 'high' => 0.86, 'very_high' => 0.71]
        ],
        'aexp' => [
            'name' => 'Experiencia en la Aplicación (AEXP)',
            'values' => ['very_low' => 1.29, 'low' => 1.13, 'nominal' => 1.00, 'high' => 0.91, 'very_high' => 0.82]
        ],
        'pcap' => [
            'name' => 'Capacidad del Programador (PCAP)',
            'values' => ['very_low' => 1.42, 'low' => 1.17, 'nominal' => 1.00, 'high' => 0.86, 'very_high' => 0.70]
        ],
        'vexp' => [
            'name' => 'Experiencia en Plataforma / Entorno (PEXP / VEXP)',
            'values' => ['very_low' => 1.19, 'low' => 1.10, 'nominal' => 1.00, 'high' => 0.90, 'very_high' => 0.85]
        ],
        'ltex' => [
            'name' => 'Experiencia en Lenguaje / Herramientas (LTEX)',
            'values' => ['very_low' => 1.14, 'low' => 1.07, 'nominal' => 1.00, 'high' => 0.95, 'very_high' => 0.84]
        ],
        'modp' => [
            'name' => 'Prácticas Modernas de Programación (MODP)',
            'values' => ['very_low' => 1.24, 'low' => 1.10, 'nominal' => 1.00, 'high' => 0.91, 'very_high' => 0.82]
        ],
        'tool' => [
            'name' => 'Uso de Herramientas de Software (TOOL)',
            'values' => ['very_low' => 1.24, 'low' => 1.10, 'nominal' => 1.00, 'high' => 0.91, 'very_high' => 0.83]
        ],
        'sced' => [
            'name' => 'Cronograma de Desarrollo Requerido (SCED)',
            'values' => ['very_low' => 1.23, 'low' => 1.08, 'nominal' => 1.00, 'high' => 1.04, 'very_high' => 1.10]
        ],
    ];

     public function getCostDriversDefinition(): array
    {
        return self::COST_DRIVERS_DEFINITION;
    }


    public function calculate(string $mode, float $kloc, array $drivers, float $salary = 0): array
    {
        if ($kloc <= 0) {
            return $this->getEmptyResult()['main'];
        }

        $eaf = 1.0;
        $eafDetails = [];
        foreach ($this->getCostDriversDefinition() as $driverKey => $driverData) {
            $selectedValue = $drivers[$driverKey] ?? 'nominal';
            $multiplier = $driverData['values'][$selectedValue] ?? 1.00;
            $eaf *= $multiplier;
            $eafDetails[$driverKey] = $multiplier;
        }

        $constants = self::CONSTANTS[$mode];


        $eaf_for_pm = floor($eaf * 100) / 100;

        // 1. Se calcula PM (Esfuerzo) con el EAF truncado.
        $pm_unrounded = $constants['a'] * pow($kloc, $constants['b']) * $eaf_for_pm;

        // 2. Se redondea PM y este valor se usará para TODOS los demás cálculos.
        $pm_rounded = round($pm_unrounded, 2);

        // 3. Los cálculos subsecuentes usan el PM ya redondeado.
        $duration = $constants['c'] * pow($pm_rounded, $constants['d']);
        $avg_staff = (round($duration, 2) > 0) ? $pm_rounded / round($duration, 2) : 0;
        $total_cost = $pm_rounded * $salary;

        return [
            'pm_adjusted' => $pm_rounded,
            'duration' => round($duration, 2),
            'avg_staff' => round($avg_staff, 2),
            'total_cost' => round($total_cost, 2),
            'eaf' => round($eaf, 3), // Se muestra el EAF con 3 decimales para precisión visual.
            'eaf_details' => $eafDetails,
        ];
    }


    public function calculateAllModes(float $kloc, array $drivers, float $salary = 0): array
    {
        if ($kloc <= 0) {
            return $this->getEmptyResult();
        }

        $eaf = 1.0;
        $eafDetails = [];
        foreach ($this->getCostDriversDefinition() as $driverKey => $driverData) {
            $selectedValue = $drivers[$driverKey] ?? 'nominal';
            $multiplier = $driverData['values'][$selectedValue] ?? 1.00;
            $eaf *= $multiplier;
            $eafDetails[$driverKey] = $multiplier;
        }

        // Se trunca el EAF a 2 decimales.
        $eaf_for_pm = floor($eaf * 100) / 100;

        $results = [];
        $modesToCalculate = ['organic', 'semidetached', 'embedded'];

        foreach ($modesToCalculate as $currentMode) {
            $constants = self::CONSTANTS[$currentMode];

            // Se aplica la misma lógica de redondeo en cadena.
            $pm_unrounded = $constants['a'] * pow($kloc, $constants['b']) * $eaf_for_pm;
            $pm_rounded = round($pm_unrounded, 2);

            $duration = $constants['c'] * pow($pm_rounded, $constants['d']);
            $avg_staff = (round($duration, 2) > 0) ? $pm_rounded / round($duration, 2) : 0;
            $total_cost = $pm_rounded * $salary;

            $results[$currentMode] = [
                'pm_adjusted' => $pm_rounded,
                'duration' => round($duration, 2),
                'avg_staff' => round($avg_staff, 2),
                'total_cost' => round($total_cost, 2),
            ];
        }

        $results['eaf'] = round($eaf, 3);
        $results['eaf_details'] = $eafDetails;

        return $results;
    }

    private function getEmptyResult(): array
    {
        $empty = ['pm_adjusted' => 0, 'duration' => 0, 'avg_staff' => 0, 'total_cost' => 0];
        return [
            'main' => $empty,
            'organic' => $empty,
            'semidetached' => $empty,
            'embedded' => $empty,
            'eaf' => 1,
            'eaf_details' => []
        ];
    }
}

