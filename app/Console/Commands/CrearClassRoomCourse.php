<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google_Service_Classroom;
use Google_Service_Classroom_Course;

class CrearClassRoomCourse extends Command
{
    private $usuario;

    public $curso;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crear-classroom-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear curso en google classroom';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        try{
        //funcionando
      //  $client = google_client_console();

        $user = \App\Models\User::findOrFail("9e6c8578-c20b-49a8-b017-baa0b9022d5b");

        $client = google_client_console_user_logged($user);
        $classroom = new \Google_Service_Classroom($client);
        $newCourse = new \Google_Service_Classroom_Course(
            [
                'name' => 'CURSO TEST NIVELA II - ' . date('Y-m-d H:i:s'), //id generado: 754140406919
                'section' => 'Período TEST NIVELA II - '. date('Y-m-d H:i:s'), //descripción breve y visible en la card
                'description' => 'No usar este curso, es sólo para fines de prueba.',
                'room' => '100',
                'ownerId' => 'roger@activa.la',
                'courseState' => 'ACTIVE',
            ]);
            $newCourse = $classroom->courses->create($newCourse);

            $courseId = $newCourse->getId();
            $courseName = $newCourse->getName();
            $courseLink = "https://classroom.google.com/c/{$courseId}";


            $this->info("✅ Curso creado correctamente:");
            $this->line("📘 Nombre: $courseName");
            $this->line("🔗 Enlace al curso: $courseLink");
            $this->line("🆔 ID: $courseId");

            //$this->curso->curso_id = $newCourse->getId(); // id del courso classroom creado

            //        $teacher = new \Google_Service_Classroom_Teacher(array(
            //            'userId' => 'me'
            //        ));
            //        $classroom->courses_teachers->create($this->curso->curso_id, $teacher);
        } catch (\Exception $e) {
            $this->error("❌ Error al crear el curso: " . $e->getMessage());
        }

    }
}
