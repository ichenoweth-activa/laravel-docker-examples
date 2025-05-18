<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Project;
use App\Models\Metodologia;
use App\Models\ProjectMetodologia;
use App\Models\CampoFormativo;
use App\Models\ProjectCampoFormativo;
use App\Models\AreaConocimiento;
use App\Models\ProjectAreaConocimiento;
use App\Models\Disciplina;
use App\Models\ProjectDisciplina;
use App\Models\UnidadAprendizaje;
use App\Models\ProjectUnidadAprendizaje;
use App\Models\ProjectSession;
use App\Models\SessionMaterial;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use App\Models\EjeArticulador;
use App\Models\ProjectEjeArticulador;

class ImportProjectsFromGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:import-sheet';
    protected $description = 'Importa proyectos y sus relaciones desde un Google Sheet';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sheetUrl = "https://docs.google.com/spreadsheets/d/1eubouNPU6yMbauWEnuHFlEYP9frdqpT7m9u_qO1yPL0/edit?gid=0#gid=0";

        $user = User::findOrFail("9e770df4-4556-41a5-bf3c-9631c635e46b");
        $client = google_client_console_user_logged($user);
        $sheetId = substr(explode('https://docs.google.com/spreadsheets/d/', $sheetUrl)[1], 0, 44);

        $service = new \Google_Service_Sheets($client);

        $range = 'A2:AY';
        $values = $service->spreadsheets_values->get($sheetId, $range)->getValues();

        DB::beginTransaction();
        try {
            $createdProjects = [];

            foreach ($values as $rowIndex => $row) {
                $originalId = trim($row[0] ?? '');

                if (empty($originalId)) continue;


                $semestreValido = ['Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto'];
                $semestre = trim($row[15] ?? '');
                $semestre = in_array($semestre, $semestreValido) ? $semestre : null;


                if (!isset($createdProjects[$originalId])) {
                    $project = Project::create([
                        'id' => Str::uuid(),
                        'id_original_ip' => $originalId,
                        'escenario' => $row[2] ?? '',
                        'url_location_file' => $row[3] ?? '',
                        'contenido' => $row[4] ?? '',
                        'proceso_de_desarrollo_aprendizaje' => $row[5] ?? '',
                        'descripcion' => $row[6] ?? '',
                        'nombre' => $row[12] ?? 'Sin nombre',
                        'nivel' => $row[13] ?? null,
                        'grado_escolar' => $row[14] ?? null,
                        'semestre' => $semestre,
                        'lenguaje' => $row[20] ?? 'Español',
                        'producto' => '',
                        'subproducto' => '',
                        'status' => 'ORIGINAL',
                        'materiales_listos' => 1,
                        'classroom_id' => null,
                        'implementado_por_user_id' => null,
                    ]);


                    //  ejes articuladores
                    //columna b
                    if (!empty($row[1])) {
                        $ejes = array_map('trim', explode(',', $row[1]));

                        foreach ($ejes as $eje) {
                            if ($eje !== '') {
                                $ejeArticulador = EjeArticulador::firstOrCreate(['name' => $eje], ['id' => Str::uuid()]);
                                //test
                                ProjectEjeArticulador::firstOrCreate([
                                    'project_id' => $project->id,
                                    'eje_articulador_id' => $ejeArticulador->id,
                                ], ['id' => Str::uuid()]);
                            }
                        }
                    }

                    if (!empty($row[7])) {
                        $campo = CampoFormativo::firstOrCreate(['name' => $row[7]], ['id' => Str::uuid()]);
                        ProjectCampoFormativo::create(['project_id' => $project->id, 'campo_formativo_id' => $campo->id]);
                    }

                    if (!empty($row[8])) {
                        $area = AreaConocimiento::firstOrCreate(['name' => $row[8]], ['id' => Str::uuid()]);
                        ProjectAreaConocimiento::create(['project_id' => $project->id, 'area_conocimiento_id' => $area->id]);
                    }

                    if (!empty($row[9])) {
                        $disciplina = Disciplina::firstOrCreate(['name' => $row[9]], ['id' => Str::uuid()]);
                        ProjectDisciplina::create(['project_id' => $project->id, 'disciplina_id' => $disciplina->id]);
                    }

                    if (!empty($row[10])) {
                        $unidad = UnidadAprendizaje::firstOrCreate(['name' => $row[10]], ['id' => Str::uuid()]);
                        ProjectUnidadAprendizaje::create(['project_id' => $project->id, 'unidad_aprendizaje_id' => $unidad->id]);
                    }

                    if (!empty($row[11])) {
                        $metodologia = Metodologia::firstOrCreate(['name' => $row[11]], ['id' => Str::uuid()]);
                        ProjectMetodologia::create(['project_id' => $project->id, 'metodologia_id' => $metodologia->id]);
                    }

                    $createdProjects[$originalId] = $project;
                    $this->info("Proyecto creado: {$project->nombre}");
                } else {
                    $project = $createdProjects[$originalId];
                }

                // Crear sesión y materiales
                if (!empty($row[16]) || !empty($row[18]) || !empty($row[19])) {
                    $session = ProjectSession::create([
                        'id' => Str::uuid(),
                        'project_id' => $project->id,
                        'sesion' => $row[16] ?? 'Sesión',
                        'duracion' => $row[17] ?? null,
                        'instrucciones_estudiante' => $row[18] ?? '',
                        'instrucciones_docente' => $row[19] ?? null,
                    ]);

                    for ($i = 21; $i <= 50; $i += 2) {
                        $nombreMaterial = $row[$i - 1] ?? null;
                        $liga = $row[$i] ?? null;

                        if ($nombreMaterial && $liga) {
                            SessionMaterial::create([
                                'id' => Str::uuid(),
                                'project_session_id' => $session->id,
                                'nombre_material' => $nombreMaterial,
                                'liga' => $liga,
                                'file_id' => null,
                            ]);
                        }
                    }

                    $this->info("Sesión importada: {$session->sesion} del proyecto {$project->nombre}");
                }
            }

            $this->info("✅ Importación finalizada correctamente.");
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            $this->error('❌ Error during import: ' . $e->getMessage());
            return 1;
        }


    }

}

