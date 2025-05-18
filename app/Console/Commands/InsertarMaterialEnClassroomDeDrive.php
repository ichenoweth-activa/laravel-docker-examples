<?php

namespace App\Console\Commands;

use Google_Service_Classroom_CourseWorkMaterial;
use Illuminate\Console\Command;

class InsertarMaterialEnClassroomDeDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insertar-material-en-classroom-de-drive';

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
        //655599786186
        $client = google_client_console();
        $classroom = new \Google_Service_Classroom($client);

        $driveFile = new \Google_Service_Classroom_DriveFile();
        $driveFile->setId('1xZIEUgpI4pA9CyTwwOZlWv5slvlJFyGW'); //id del recurso en drive a insertar

        $sharedDrivefile = new \Google_Service_Classroom_SharedDriveFile();
        $sharedDrivefile->setShareMode('VIEW');
        $sharedDrivefile->setDriveFile($driveFile);
        $material = new \Google_Service_Classroom_Material([
            'driveFile' => $sharedDrivefile,
        ]);

        // crea un objeto CourseWorkMaterial con el DriveFile adjunto
        $courseWorkMaterial = new Google_Service_Classroom_CourseWorkMaterial([
            'title' => 'Tarea 1 del curso',
            'description' => 'Descripción del trabajo',
            //'state' => 'PUBLISHED',
            'materials' => [$material],
            //'workType' => 'ASSIGNMENT'
        ]);

        // ID del curso al que pertenece el trabajo de curso
        $courseId = '655599786186';
        // Crea el recurso de trabajo de curso
        $createdCourseWorkMaterial = $classroom->courses_courseWorkMaterials->create($courseId, $courseWorkMaterial);

    }
}
