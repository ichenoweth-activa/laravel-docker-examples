<?php

namespace App\Console\Commands;

use Google_Service_Classroom_CourseWorkMaterial;
use Illuminate\Console\Command;

class InsertarMaterialEnClassroomVinculo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insertar-material-en-classroom-vinculo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $courseId = '655599786186';
        $client = google_client_console();
        $classroom = new \Google_Service_Classroom($client);

        $url = str_replace('\\/', '/', 'https://www.youtube.com/watch?v=v2c5QHtgFxY');
        $link = new \Google_Service_Classroom_Link();
        $link->setUrl($url); //link de url de algún material, etc.

        $materialNuevo = new \Google_Service_Classroom_Material();
        $materialNuevo->setLink($link);
        $courseWorkMaterial = new Google_Service_Classroom_CourseWorkMaterial([
            'title' => 'Tarea 2 Documental',
            'description' => 'Acceso a material video en la liga URL',
            'materials' => [$materialNuevo],
        ]);

        $createdCourseWorkMaterial = $classroom->courses_courseWorkMaterials->create($courseId, $courseWorkMaterial);

    }
}
