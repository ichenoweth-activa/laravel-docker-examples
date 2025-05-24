<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen del Proyecto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 40px;
            position: relative;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        h2 {
            font-size: 18px;
            margin-top: 25px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        p {
            margin: 6px 0;
            line-height: 1.6;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        .header-logo {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 90px;
            height: auto;
        }

        .project-image {
            display: block;
            margin: 0 auto 25px auto;
            max-width: 400px;
            height: auto;
            border-radius: 4px;
        }

        .section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

{{-- Logo fijo de la marca Impulsa --}}
<img src="{{ public_path('images/impulsa-logo.png') }}" alt="Logo Impulsa" class="header-logo" />

<h1>{{ $project->nombre }}</h1>

{{-- Imagen del proyecto centrada --}}
@if ($project->url_location_file)
    <img src="{{ $project->url_location_file }}" alt="Imagen del proyecto" class="project-image" />
@endif

<div class="section">
    <p><strong>Contenido:</strong> {{ $project->contenido }}</p>
    <p><strong>Descripción:</strong> {{ $project->descripcion }}</p>
    <p><strong>Proceso de Desarrollo del Aprendizaje:</strong> {{ $project->proceso_desarrollo_aprendizaje }}</p>
    <p><strong>Lenguaje:</strong> {{ $project->lenguaje }}</p>
    <p><strong>Nivel:</strong> {{ $project->nivel }}</p>
    <p><strong>Producto:</strong> {{ $project->producto }}</p>
    <p><strong>Subproducto:</strong> {{ $project->subproducto }}</p>
    <p><strong>Grado Escolar:</strong> {{ $project->grado_escolar }}</p>
</div>

@if ($project->disciplinas->isNotEmpty())
    <div class="section">
        <h2>Disciplinas</h2>
        <ul>
            @foreach ($project->disciplinas as $disciplina)
                <li>{{ $disciplina->name }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($project->campoFormativos->isNotEmpty())
    <div class="section">
        <h2>Campos Formativos</h2>
        <ul>
            @foreach ($project->campoFormativos as $campo)
                <li>{{ $campo->name }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($project->projectSession->isNotEmpty())
    <div class="section">
        <h2>Instrucciones del Docente</h2>
        <ul>
            @foreach ($project->projectSession as $session)
                @if ($session->instrucciones_docente)
                    <li>{{ $session->instrucciones_docente }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>
