<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EnrollStudentClassRoomCourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enroll-student-class-room-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pone a un estudiante en un curso de classroom';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //funcionando

        //curso id  661004706980
        //curso     introducción a las tecnologías del conocimiento

        $client = google_client_console();
        $classroom = new \Google_Service_Classroom($client);

        $alumno = new \Google_Service_Classroom_Student([
            'userId' => 'cristina.franco@g.nive.la',
        ]);                                         //id course google
        //$classroom->courses_students->create($this->curso->curso_id , $alumno);
        $classroom->courses_students->create('661004706980', $alumno);

    }
}
