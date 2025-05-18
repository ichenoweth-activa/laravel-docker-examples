<?php

namespace Database\Seeders;

use App\Models\AreaConocimiento;
use App\Models\CampoFormativo;
use App\Models\Metodologia;
use App\Models\ProjectAreaConocimiento;
use App\Models\ProjectCampoFormativo;
use App\Models\ProjectMetodologia;
use App\Models\EjeArticulador;
use App\Models\ProjectEjeArticulador;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectSession;
use App\Models\SessionMaterial;
use Illuminate\Support\Str;
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $project = Project::create([
            'id' => Str::uuid(),
            'nombre' => 'Proyecto de Ejemplo (seeded) '. date('Y-m-d H:i:s'),
            'descripcion' => 'Este es un proyecto de ejemplo para pruebas.',
            'proceso_desarrollo_aprendizaje'=>'Ejemplo de proceso de PDA',
            'contenido' => 'Contenido del proyecto...',
            'lenguaje' => 'Español',
            'nivel' => 'Primaria',
            'producto' => 'Producto final del proyecto',
            'subproducto' => 'Subproducto del proyecto',
            'escenario' => 'Aula de clase',
            'grado_escolar' => '5',
            'status' => 'ORIGINAL',
            'classroom_id' => null,
            'materiales_listos' => 1,
            'file_id' => null,
            'file_name' => null,
            'url_location_file' => "https://storage.googleapis.com/alejandria/imagenes_proyectos/Proyectos%20Alejandr%C3%ADa%20Provisional/F3-ENS_ABPbm_Portadas%20Activa.png",
            'implementado_por_user_id' => null,
        ]);

        // Crear sesiones para el proyecto
        $session1 = ProjectSession::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'sesion' => "Sesión 1",
            'instrucciones_estudiante' => 'Instrucciones para la sesión 1...',
        ]);

        $session2 = ProjectSession::create([
            'id' => Str::uuid(),
            'project_id' => $project->id,
            'sesion' => "Sesión 2",
            'instrucciones_estudiante' => 'Instrucciones para la sesión 2...',
        ]);

        // Crear materiales para la sesión 1
        SessionMaterial::create([
            'id' => Str::uuid(),
            'project_session_id' => $session1->id,
            'nombre_material' => 'Ejemplo - Crea tu historia',
            'liga' => 'https://heyzine.com/flip-book/86a9cfdffc.html',
            'file_id' => '9qGxMNt7TBVb_gEzTgpYO',
        ]);

        SessionMaterial::create([
            'id' => Str::uuid(),
            'project_session_id' => $session1->id,
            'nombre_material' => '¿Cómo llego?',
            'liga' => 'https://www.canva.com/design/DAGHabwKdTY/busQca93oARMBo-QjQJ8NQ/view?embed',
            'file_id' => 'd2apn_9ei2NbKNwxYEmFs',
        ]);

        // Crear materiales para la sesión 2
        SessionMaterial::create([
            'id' => Str::uuid(),
            'project_session_id' => $session2->id,
            'nombre_material' => 'Cuento mudo - Diario de trabajo',
            'liga' => 'https://docs.google.com/document/d/19kKXSsVZgbuNyfIqjthVpQIdiZwk7TMy5C5WB46co5E/edit?usp=sharing',
            'file_id' => '0p2fPntPViLQOY9nXfTIm',
        ]);

        // Obtener o crear metodologías
        $metodologia1 = Metodologia::firstOrCreate([
            'name' => 'Aprendizaje Basado en Proyectos',
        ], [
            'id' => Str::uuid(),
        ]);

        $metodologia2 = Metodologia::firstOrCreate([
            'name' => 'Aprendizaje basado en la Indagación con enfoque en STEAM',
        ], [
            'id' => Str::uuid(),
        ]);

        // Crear registros en la tabla pivot ProjectMetodologia
        ProjectMetodologia::create([
            'project_id' => $project->id,
            'metodologia_id' => $metodologia1->id,
        ]);

        ProjectMetodologia::create([
            'project_id' => $project->id,
            'metodologia_id' => $metodologia2->id,
        ]);

        // Obtener o crear campos formativos
        $campoFormativo1 = CampoFormativo::firstOrCreate([
            'name' => 'Lenguajes',
        ], [
            'id' => Str::uuid(),
        ]);

        $campoFormativo2 = CampoFormativo::firstOrCreate([
            'name' => 'Ciencias Naturales, Experimentales y Tecnología',
        ], [
            'id' => Str::uuid(),
        ]);

        ProjectCampoFormativo::create([
            'project_id' => $project->id,
            'campo_formativo_id' => $campoFormativo1->id,
        ]);

        ProjectCampoFormativo::create([
            'project_id' => $project->id,
            'campo_formativo_id' => $campoFormativo2->id,
        ]);


        $AreaConocimiento = AreaConocimiento::firstOrCreate([
            'name' => 'Conciencia Histórica',
        ], [
            'id' => Str::uuid(),
        ]);

        ProjectAreaConocimiento::create([
            'project_id' => $project->id,
            'area_conocimiento_id' => $AreaConocimiento->id,
        ]);

        $ejesAsignar = [
            ['name' => 'Pensamiento crítico', 'image_url' => 'pensamiento.png'],
            ['name' => 'Vida saludable', 'image_url' => 'vida_saludable.png'],
        ];

        foreach ($ejesAsignar as $eje) {
            $ejeModel = EjeArticulador::firstOrCreate(
                ['name' => $eje['name']],
                ['id' => Str::uuid(), 'image_url' => $eje['image_url']]
            );

            ProjectEjeArticulador::create([
                'project_id' => $project->id,
                'eje_articulador_id' => $ejeModel->id,
            ]);
        }

    }
}
