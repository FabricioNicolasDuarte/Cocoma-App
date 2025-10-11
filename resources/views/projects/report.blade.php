<!DOCTYPE html>
<html lang="es">
@php
$imagePath = public_path('images/pdf/mi-fondo.png');
$logoPath = public_path('images/pdf/mi-logo.png');

if (file_exists($imagePath)) {
    $type = pathinfo($imagePath, PATHINFO_EXTENSION);
    $data = file_get_contents($imagePath);
    $backgroundImage = 'data:image/' . $type . ';base64,' . base64_encode($data);
} else {
    $backgroundImage = 'none';
}

if (file_exists($logoPath)) {
    $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
    $logoData = file_get_contents($logoPath);
    $logoImage = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
} else {
    $logoImage = '';
}
@endphp
<head>
<meta charset="UTF-8">
<title>Informe de Estimación Costos con COCOMO I - {{ $project->project_name }}</title>
<style>
@page {
    margin: 2.5cm 2.5cm 3cm 2.5cm;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    color: #09223a;
    font-size: 12px;
    margin: 0;
    background: none !important;
    position: relative;
    line-height: 1.5;
}

.background-fullpage {
    position: fixed;
    top: -2.5cm;
    left: -2.5cm;
    right: -2.5cm;
    bottom: -3cm;
    z-index: 0;
    background-image: url("{{ $backgroundImage }}");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.footer {
    position: fixed;
    left: -2.5cm;
    right: -2.5cm;
    bottom: -3cm;
    height: 1.5cm;
    text-align: center;
    font-size: 10px;
    color: #184075;
    letter-spacing: 0.5px;
    background: none;
    z-index: 10;
    padding: 0.5cm 2.5cm;
    box-sizing: border-box;
}

.footer .page-number::after {
    content: counter(page);
}

.content {
    position: relative;
    z-index: 2;
    padding: 0;
    box-sizing: border-box;
}

.page-break {
    page-break-before: always;
    break-before: page;
}

.section, table, .section table {
    page-break-inside: avoid;
    break-inside: avoid;
}

.section {
    margin-bottom: 32px;
    padding: 18px 22px;
    border-radius: 16px;
    background-color: rgba(255, 255, 255, 0.403);
    box-shadow: 0 2px 14px rgba(40, 60, 80, 0);
    color: #09223a;
}



.header-info {

    background-color: rgba(255,255,255,0.7) !important;

    border-radius: 15px; /* <-- Bordes redondeados */
}


.logo {
    background-color: rgba(255, 255, 255, 0) !important;
    text-align: center;
    border-radius: 15px;

    width: 110px;
}
.logo img {
    background-color: rgba(255, 255, 255, 0) !important;
    height: 80px;
    object-fit: contain;
    display: inline-block;
}
.title-cell {
    background-color: rgba(255, 255, 255, 0) !important;
    text-align: center;
    padding-left: 40px;
    border-radius: 15px;
}
h1 {
    font-size: 28px;
    margin-bottom: 18px;
    margin-top: 0;
    font-weight: bold;
    letter-spacing: 1px;
    color: #09223a;
}
h2 {
    font-size: 20px;
    margin-top: 0;
    font-weight: bold;
    border-bottom: 1px solid #3ca2c6;
    padding-bottom: 4px;
    color: #184075;
}
h3 {
    font-size: 16px;
    font-weight: bold;
    color: #184075;
    margin-top: 24px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 14px;
    font-size: 12px;
}
th, td {
    border: 1px solid #b2b2b2;
    padding: 8px 10px;
    text-align: left;
}
th {
    background-color: #184075;
    font-weight: bold;
    color: #ffffff;
    font-size: 12px;
    border-bottom: 2px solid #3ca2c6;
}
tr:nth-child(even) td {
    background-color: #f5faff;
    color: #09223a;
}
tr:nth-child(odd) td {
    background-color: rgba(255,255,255,0.92);
    color: #09223a;
}
.highlight {
    color: #e74c3c;
    font-weight: bold;
}
.results-table td:nth-child(2) {
    font-weight: bold;
    text-align: right;
    color: #184075;
}
ul {
    padding-left: 25px;
    list-style-position: outside;
}
li {
    margin-bottom: 8px;
}
</style>
</head>
<body>
<div class="background-fullpage"></div>

<div class="footer">
    Informe generado por COCOMA | Gestión de Proyectos de Software | {{ $date }} | Página <span class="page-number"></span>
</div>
<div class="content">
    <table class="header-info">
        <tr>
            <td class="logo">
                @if($logoImage)
                    <img src="{{ $logoImage }}" alt="Logo COCOMA">
                @endif
            </td>
            <td class="title-cell">
                <h1>Informe de Estimación Costos con COCOMO I</h1>
            </td>

        </tr>
    </table>

        <div>
    <p></p>
    </div>


    <div class="section">
        <h2>1. Datos Generales del Proyecto</h2>
        <table>
            <tr>
                <th width="30%">Nombre del Proyecto</th>
                <td>{{ $project->project_name }}</td>
            </tr>
            <tr>
                <th>Líneas de Código (KLOC)</th>
                <td>{{ number_format($project->kloc, 2) }}</td>
            </tr>
            <tr>
                <th>Modelo COCOMO Aplicado</th>
                <td>{{ ucfirst($project->cocomo_model) }}</td>
            </tr>
            <tr>
                <th>Modo del Proyecto</th>
                <td>{{ ucfirst($project->mode) }}</td>
            </tr>
            <tr>
                <th>Salario Medio Mensual Usado (en U$S)</th>
                <td>$ {{ number_format($salary, 2) }}</td>
            </tr>
            <tr>
                <th>Fecha del Informe</th>
                <td>{{ $date }}</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>
    <div class="section">
        <h2>2. Resultados de la Estimación Final</h2>
        <table class="results-table">
            <tr>
                <th width="50%">Métrica</th>
                <th width="50%">Valor Estimado</th>
            </tr>
            <tr>
                <td>Esfuerzo (Personas-Mes)</td>
                <td>{{ number_format($results['main']['pm_adjusted'], 2) }} PM</td>
            </tr>
            <tr>
                <td>Duración (Meses)</td>
                <td>{{ number_format($results['main']['duration'], 2) }} Meses</td>
            </tr>
            <tr>
                <td>Personal Promedio Requerido</td>
                <td>{{ number_format($results['main']['avg_staff'], 2) }} Personas</td>
            </tr>
            <tr>
                <td>Costo Total (U$S)</td>
                <td>$ {{ number_format($results['main']['total_cost'], 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>
    <div class="section">
        <h2>3. Análisis de Factores de Costo (EAF)</h2>
        <p>El Factor de Ajuste de Esfuerzo (EAF) total calculado para este proyecto es: <strong>{{ number_format($results['eaf'], 3) }}</strong>.</p>
        <table>
            <thead>
                <tr>
                    <th>Factor de Costo</th>
                    <th>Valor Asignado</th>
                    <th>Multiplicador</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $optionNames = ['very_low' => 'Muy Bajo', 'low' => 'Bajo', 'nominal' => 'Nominal', 'high' => 'Alto', 'very_high' => 'Muy Alto', 'extra_high' => 'Extra Alto'];
                @endphp
                @foreach($project->cost_drivers as $key => $selectedValue)
                    @if(isset($driversDefinition[$key]))
                        @php
                            $driver = $driversDefinition[$key];
                            $multiplier = $driver['values'][$selectedValue] ?? 1.0;
                        @endphp
                        <tr>
                            <td>{{ $driver['name'] }}</td>
                            <td>{{ $optionNames[$selectedValue] ?? ucfirst(str_replace('_', ' ', $selectedValue)) }}</td>
                            <td>{{ number_format($multiplier, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>
    <div class="section">
        <h2>4. Métricas Adicionales y Análisis de Sensibilidad</h2>
        <h3>Métricas de Productividad</h3>
        <table>
            <tr>
                <th width="50%">Métrica</th>
                <th width="50%">Valor</th>
            </tr>
            <tr>
                <td>Productividad</td>
                <td>
                    @if($results['main']['pm_adjusted'] > 0)
                        {{ number_format($project->kloc / $results['main']['pm_adjusted'], 2) }} KLOC / PM
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <td>Costo por KLOC ($)</td>
                <td>
                    @if($project->kloc > 0)
                        $ {{ number_format($results['main']['total_cost'] / $project->kloc, 2) }} / KLOC
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        </table>
        <h3>Análisis de Sensibilidad: Factores de Mayor Impacto</h3>
        @php
            $eafDetails = collect($results['eaf_details'])->map(function ($value, $key) {
                return ['key' => $key, 'value' => $value, 'impact' => abs(1 - $value)];
            })->sortByDesc('impact')->take(3);
        @endphp
        <p>Los 3 factores que más han influido en la estimación final son:</p>
        <ul>
            @foreach($eafDetails as $detail)
                <li>
                    <strong>{{ $driversDefinition[$detail['key']]['name'] }}:</strong>
                    @if($detail['value'] > 1)
                        incrementó el esfuerzo en un <span class="highlight">{{ number_format(($detail['value'] - 1) * 100, 1) }}%</span>.
                    @elseif($detail['value'] < 1)
                        redujo el esfuerzo en un <span class="highlight">{{ number_format((1 - $detail['value']) * 100, 1) }}%</span>.
                    @else
                        tuvo un impacto neutro.
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div class="page-break"></div>
    <div class="section">
        <h2>5. Tabla Comparativa de Modos</h2>
        <p>A continuación se presenta una tabla comparativa de la estimación del proyecto si se hubiera desarrollado bajo los diferentes modos de COCOMO.</p>
        <table>
            <thead>
                <tr>
                    <th>Métrica</th>
                    <th>Orgánico</th>
                    <th>Semi-acoplado</th>
                    <th>Empotrado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Esfuerzo (PM)</td>
                    <td>{{ number_format($allModesComparison['organic']['pm_adjusted'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['semidetached']['pm_adjusted'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['embedded']['pm_adjusted'], 2) }}</td>
                </tr>
                <tr>
                    <td>Duración (Meses)</td>
                    <td>{{ number_format($allModesComparison['organic']['duration'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['semidetached']['duration'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['embedded']['duration'], 2) }}</td>
                </tr>
                <tr>
                    <td>Personal Promedio</td>
                    <td>{{ number_format($allModesComparison['organic']['avg_staff'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['semidetached']['avg_staff'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['embedded']['avg_staff'], 2) }}</td>
                </tr>
                <tr>
                    <td>Costo Total (U$S)</td>
                    <td>{{ number_format($allModesComparison['organic']['total_cost'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['semidetached']['total_cost'], 2) }}</td>
                    <td>{{ number_format($allModesComparison['embedded']['total_cost'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
