<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateCourseTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-course-topic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'asigna un tema a un curso de classroom en base al id del course en classroom';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $cursoId = '655599786186';
        //si funciona
        $client = google_client_console();
        $classroom = new \Google_Service_Classroom($client);
        $newTopic = new \Google_Service_Classroom_Topic([
            'name' => 'Tema 3. Activos de información',
        ]);

        $newTopic = $classroom->courses_topics->create($cursoId, $newTopic);

    }
}
