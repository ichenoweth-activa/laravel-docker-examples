<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectSession;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    public function update(Request $request, $project)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'sesion' => 'required',
            'project_id' => 'required'
        ]);
        $sesion = ProjectSession::findOrFail($validatedData['id']);
        $sesion->sesion = $validatedData['sesion'];
        $sesion->instrucciones_docente = $request->instrucciones_docente;
        $sesion->instrucciones_estudiante = $request->instrucciones_estudiante;
        $sesion->save();

        $project = Project::with(['metodologias', 'campoFormativos', 'projectSession.materials','disciplinas'])
            ->where('id', $validatedData['project_id'])
            ->firstOrFail();
        return redirect()->route('project.edit', ['project' => $project->id])
            ->with('success', 'Sesión Actualizada con éxito');
    }
}
