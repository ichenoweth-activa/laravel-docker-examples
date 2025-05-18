<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

use App\Models\Project;
use App\Models\User;
use App\Models\CampoFormativo;
use App\Models\ProjectCampoFormativo;
use App\Models\AreaConocimiento;
use App\Models\ProjectAreaConocimiento;
use App\Models\Disciplina;
use App\Models\ProjectDisciplina;
use App\Models\UnidadAprendizaje;
use App\Models\ProjectUnidadAprendizaje;
use App\Models\Metodologia;
use App\Models\ProjectMetodologia;
use App\Models\EjeArticulador;
use App\Models\ProjectEjeArticulador;

class UpdateProjectsFromGoogleSheet extends Command
{
    protected $signature = 'projects:update-sheet';
    protected $description = 'Actualiza proyectos existentes desde un Google Sheet según el id_original_ip';

    public function handle()
    {
        $sheetUrl = "https://docs.google.com/spreadsheets/d/1eubouNPU6yMbauWEnuHFlEYP9frdqpT7m9u_qO1yPL0/edit?gid=0#gid=0";
        $user = User::findOrFail("9e770df4-4556-41a5-bf3c-9631c635e46b");
        $client = google_client_console_user_logged($user);
        $sheetId = substr(explode('https://docs.google.com/spreadsheets/d/', $sheetUrl)[1], 0, 44);

        $service = new \Google_Service_Sheets($client);
        $range = 'A2:AL';
        $values = $service->spreadsheets_values->get($sheetId, $range)->getValues();

        DB::beginTransaction();
        try {
            foreach ($values as $row) {
                $originalId = trim($row[0] ?? '');
                if (empty($originalId)) continue;

                $project = Project::where('id_original_ip', $originalId)->first();
                if (!$project) {
                    $this->warn("Proyecto no encontrado: {$originalId}");
                    continue;
                }

                // update campos del project
                $project->update([
                    'nombre' => $row[11] ?? 'Sin nombre',
                    'contenido' => $row[3] ?? '',
                    'descripcion' => $row[5] ?? '',
                    'proceso_de_desarrollo_aprendizaje' => $row[4] ?? '',
                    'lenguaje' => $row[17] ?? null,
                    'nivel' => $row[12] ?? null,
                    'grado_escolar' => $row[13] ?? null,
                    'url_location_file' => $row[2] ?? null,
                ]);

                // Limpiar relaciones
                $project->campoFormativos()->detach();
                $project->areaConocimientos()->detach();
                $project->disciplinas()->detach();
                $project->unidadesAprendizaje()->detach();
                $project->metodologias()->detach();
                $project->ejesArticuladores()->detach();

                // Reasignar relaciones
                if (!empty($row[6])) {
                    $campo = CampoFormativo::firstOrCreate(['name' => $row[6]], ['id' => Str::uuid()]);
                    $project->campoFormativos()->attach($campo->id);
                }

                if (!empty($row[7])) {
                    $area = AreaConocimiento::firstOrCreate(['name' => $row[7]], ['id' => Str::uuid()]);
                    $project->areaConocimientos()->attach($area->id);
                }

                if (!empty($row[8])) {
                    $disciplina = Disciplina::firstOrCreate(['name' => $row[8]], ['id' => Str::uuid()]);
                    $project->disciplinas()->attach($disciplina->id);
                }

                if (!empty($row[9])) {
                    $unidad = UnidadAprendizaje::firstOrCreate(['name' => $row[9]], ['id' => Str::uuid()]);
                    $project->unidadesAprendizaje()->attach($unidad->id);
                }

                if (!empty($row[10])) {
                    $metodologia = Metodologia::firstOrCreate(['name' => $row[10]], ['id' => Str::uuid()]);
                    $project->metodologias()->attach($metodologia->id);
                }

                if (!empty($row[1])) {
                    $ejes = array_map('trim', explode(',', $row[1]));
                    foreach ($ejes as $eje) {
                        if ($eje !== '') {
                            $ejeModel = EjeArticulador::firstOrCreate(['name' => $eje], ['id' => Str::uuid()]);
                            $project->ejesArticuladores()->attach($ejeModel->id);
                        }
                    }
                }

                $this->info("✅ Proyecto actualizado: {$project->nombre}");
            }

            DB::commit();
            $this->info("✅ Actualización completa.");
        } catch (Exception $e) {
            DB::rollBack();
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }
    }
}
