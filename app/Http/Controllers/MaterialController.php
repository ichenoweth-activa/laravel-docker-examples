<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SessionMaterial;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function update(Request $request, $project)
    {
       // dd($project);
        $validatedData = $request->validate([
            'id' => 'required',
            'nombre_material' => 'required',
            'liga' => 'required'
        ]);
        $material = SessionMaterial::findOrFail($validatedData['id']);
        $material->nombre_material = $validatedData['nombre_material'];
        $material->liga = $validatedData['liga'];
        $material->save();

        $project = Project::with(['metodologias', 'campoFormativos', 'projectSession.materials','disciplinas'])
            ->where('id', $project)
            ->firstOrFail();
        return redirect()->route('project.edit', ['project' => $project])
            ->with('success', 'Material Actualizado con éxito');
    }
}
