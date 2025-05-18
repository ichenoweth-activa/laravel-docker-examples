<?php

namespace App\Http\Controllers;



use App\Actions\UserClient;
use App\Jobs\CreateClassroomJob;
use App\Models\Campaign;

use App\Models\AreaConocimiento;

use App\Models\CampoFormativo;
use App\Models\Disciplina;
use App\Models\Metodologia;
use App\Models\Project;
use App\Models\ProjectCampoFormativo;
use App\Models\ProjectDisciplina;
use App\Models\ProjectMetodologia;
use App\Models\ProjectSession;
use App\Models\ProjectUnidadAprendizaje;
use App\Models\UnidadAprendizaje;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'projectNombre' => 'nullable',
            'metodologias' => 'nullable|array',
            'campos_formativos' => 'nullable|array',
            'nivel' => 'nullable|array',
            'disciplinas' => 'nullable|array',
            'unidadAprendizajes'=>'nullable|array',
            'areaConocimientos'=>'nullable|array',
            'idioma'=>'nullable|in:Español,Inglés',
        ]);

        $selectedprojectNombre = null;
        $selectedMetodologias = null;
        $selectedCamposFormativos = null;
        $selectedDisciplina = null;
        $selectedNivel = null;
        $selectedUnidadAprendizaje=null;
        $selectedAreaconocimientos=null;
        $selectedIdioma = null;

        $query = Project::with(['metodologias', 'campoFormativos', 'disciplinas','unidadesAprendizaje', 'areaConocimientos','ejesArticuladores']);

        if (!empty($validatedData['projectNombre'])) {
            $query->where('nombre', 'like', '%' . $validatedData['projectNombre'] . '%');
            $selectedprojectNombre = $validatedData['projectNombre'];
        }

        if (!empty($validatedData['metodologias'])) {
            $query->whereHas('metodologias', function ($q) use ($validatedData) {
                $q->whereIn('metodologias.id', $validatedData['metodologias']);
            });
            $selectedMetodologias = $validatedData['metodologias'];
        }

        if (!empty($validatedData['campos_formativos'])) {
            $query->whereHas('campoFormativos', function ($q) use ($validatedData) {
                $q->whereIn('campo_formativos.id', $validatedData['campos_formativos']);
            });
            $selectedCamposFormativos = $validatedData['campos_formativos'];
        }

        if (!empty($validatedData['nivel'])) {
            $query->whereIn("projects.nivel", $validatedData['nivel']);
            $selectedNivel = $validatedData['nivel'];
        }

        if (!empty($validatedData['idioma'])) {
            $query->where("projects.lenguaje", $validatedData['idioma']);
            $selectedIdioma = $validatedData['idioma'];
        }

        if (!empty($validatedData['disciplinas'])) {
            $query->whereHas('disciplinas', function($q) use ($validatedData) {
                $q->whereIn('disciplinas.id', $validatedData['disciplinas']);
            });
            $selectedDisciplina = $validatedData['disciplinas'];
        }

        if (!empty($validatedData['unidadAprendizajes'])) {
            $query->whereHas('unidadesAprendizaje', function($q) use ($validatedData) {
                $q->whereIn('unidad_aprendizaje.id', $validatedData['unidadAprendizajes']);
            });
            $selectedUnidadAprendizaje = $validatedData['unidadAprendizajes'];
        }

        if (!empty($validatedData['areaConocimientos'])) {
            $query->whereHas('areaConocimientos', function($q) use ($validatedData) {
                $q->whereIn('area_conocimientos.id', $validatedData['areaConocimientos']);
            });
            $selectedAreaconocimientos = $validatedData['areaConocimientos'];
        }



        $projects = $query->paginate(5)->withQueryString();


        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'metodologiasData' => Metodologia::all(),
            'camposformativosData' => CampoFormativo::all(),
            'disciplinasData'=>Disciplina::all(),
            'unidadAprendizajesData'=>UnidadAprendizaje::all(),
            'areaconocimientosData' => AreaConocimiento::all(),
            'areaconocimientos' => $selectedAreaconocimientos,
            'projectNombre' => $selectedprojectNombre,
            'metodologias'=>$selectedMetodologias,
            'campos_formativos'=>$selectedCamposFormativos,
            'disciplinas' => $selectedDisciplina,
            'nivel' => $selectedNivel,
            'unidadAprendizajes' => $selectedUnidadAprendizaje,

            'idioma' => $selectedIdioma,
        ]);

    }

    public function show($uuid)
    {
        $project = Project::with(['metodologias', 'campoFormativos', 'projectSession.materials','disciplinas'])
            ->where('id', $uuid)
            ->firstOrFail();


        return Inertia::render('Projects/Show', [
            'project' => $project,
            'metodologia' => $project->metodologia
            /*'projects' => $projects,
            'metodologiasData'=>Metodologia::all(),
            'camposformativosData'=>CampoFormativo::all(),
            'projectNombre' => $selectedprojectNombre,
            'metodologias'=>$selectedMetodologias,
            'campos_formativos'=>$selectedCamposFormativos,
            'nivel' => $selectedNivel,*/
        ]);

    }

    public function edit($uuid)
    {
        $project = Project::with(['metodologias', 'campoFormativos', 'projectSession.materials','disciplinas',
            'areaConocimientos','unidadesAprendizaje','projectSession'])
            ->where('id', $uuid)
            ->firstOrFail();
        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'metodologiaSelected' => $project->metodologias,
            'metodologiasData' => Metodologia::all(),
            'camposFormativosSelected' => $project->campoFormativos,
            'camposFormativosData' => CampoFormativo::all(),
            'disciplinasData' => Disciplina::all(),
            'areasConocimientosData' => AreaConocimiento::all(),
            'unidadesAprendizajeData' =>  UnidadAprendizaje::all(),
        ]);
    }
    public function editSession($uuid,$session)
    {
        $project = Project::with(['metodologias', 'campoFormativos', 'projectSession.materials','disciplinas',
            'areaConocimientos','unidadesAprendizaje','projectSession'])
            ->where('id', $uuid)
            ->firstOrFail();

        $session = ProjectSession::with(['materials'])
            ->where('id', $session)
            ->firstOrFail();
        return Inertia::render('Projects/Session/Edit', [
            'project' => $project,
            'session'=>$session,
        ]);
    }

    public function implementar(Request $request)
    {
        CreateClassroomJob::dispatch(auth()->user()->id,
            $request->id,
        );
    }

    public function update(Request $request, $id)
    {
        //dd($request->toArray());
        $validatedData = $request->validate([
            'nombre' => 'required',
            'nivel' => 'required',
            'grado_escolar' => 'required',
            'descripcion' => 'required',
            'contenido' => 'required',
            'proceso_desarrollo_aprendizaje' => 'required'
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $project = Project::findOrFail($id);
        $project->update($validatedData);

        //$project->metodologias()->delete();

        ProjectUnidadAprendizaje::where('project_id', $id)->forceDelete();
        foreach ($request->unidad_aprendizaje_selected as $unidad_aprendizaje) {
            ProjectUnidadAprendizaje::firstOrCreate(
                [
                    'project_id' => $id,
                    'unidad_aprendizaje_id' => $unidad_aprendizaje['id']

                ],
                [
                    'id' => Str::uuid(),
                ],
            );
        }




        ProjectDisciplina::where('project_id', $id)->forceDelete();
        foreach ($request->disciplinas_selected as $disciplina) {
            ProjectDisciplina::firstOrCreate(
                [
                    'project_id' => $id,
                    'disciplina_id' => $disciplina['id']

                ],
                [
                    'id' => Str::uuid(),
                ],
            );
        }



        ProjectMetodologia::where('project_id', $id)->forceDelete();
        foreach ($request->metodologias as $metodologia) {
            ProjectMetodologia::firstOrCreate(
                [
                    'project_id' => $id,
                    'metodologia_id' => $metodologia['id']

                ],
                [
                'id' => Str::uuid(),
                ],
            );
        }

        ProjectCampoFormativo::where('project_id', $id)->forceDelete();
        foreach ($request->campoFormativo as $campoFormativo) {
            ProjectCampoFormativo::firstOrCreate(
                [
                    'project_id' => $id,
                    'campo_formativo_id' => $campoFormativo['id']

                ],
                [
                    'id' => Str::uuid(),
                ],
            );
        }
        return redirect()->route('project.index')->with('success', 'Registro Actualizado con éxito');

    }
}
