<?php

namespace App\Console\Commands;

use Google_Service_Classroom_CourseWorkMaterial;
use Illuminate\Console\Command;

class InsertarMaterialEnClassroomVideoDeYoutube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insertar-material-en-classroom-video-de-youtube';

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

        $driveFile = new \Google_Service_Classroom_YouTubeVideo();
        $driveFile->setId('BTFLVsNbYzg');

        $material = new \Google_Service_Classroom_Material([
            'youtubeVideo' => $driveFile,
        ]);

        $courseWorkMaterial = new Google_Service_Classroom_CourseWorkMaterial([
            'title' => 'Tarea 3 Documental Historico',
            'description' => 'Acceso a material video en la liga URL',
            'materials' => [$material],
        ]);

        $createdCourseWorkMaterial = $classroom->courses_courseWorkMaterials->create($courseId, $courseWorkMaterial);

    }
}
