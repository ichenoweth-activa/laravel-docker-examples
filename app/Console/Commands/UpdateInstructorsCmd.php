<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\CourseInstructor;
use App\Models\Instructor;
use Illuminate\Console\Command;

class UpdateInstructorsCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-instructors-cmd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $instructorsIdSeleccionados = [12];
        /*
         * Curso creado en producción: Curso Prueba (no usar)
         * 25-02-2025
         */

        $course_id='9e4cc73b-bb74-4a7d-8e0d-5f0b83e5a990';
        $instructoresIdActuales= CourseInstructor::where('course_id', $course_id)
            ->pluck('instructor_id')
            ->toArray();

        $nuevosInstructores = array_diff($instructorsIdSeleccionados, $instructoresIdActuales);
        $instructoresAEliminarDeCurso = array_diff($instructoresIdActuales, $instructorsIdSeleccionados);

        //dd($nuevos);
        //dd($nuevos,$eliminados);
        if (!is_null($nuevosInstructores)){
            foreach ($nuevosInstructores as $idInstructores){
                //$this->info($idInstructores);
                $email= Instructor::join('users', 'users.id', '=', 'instructors.user_id')
                    ->where('instructors.id', $idInstructores)
                    ->value('users.email');
                $this->info($email);
            }
        }
        $this->warn('Advertencia: eliminar datos');
        if (!is_null($instructoresAEliminarDeCurso)){
            foreach ($instructoresAEliminarDeCurso as $idInstructores){
                $this->info($idInstructores);
            }
        }

        $courseId = Course::select('id','classroom_id')
            ->where('id', $course_id)
            ->first();

        $this->info($courseId->classroom_id);

        /*$instructores= CourseInstructor::with('instructor','instructor.user')
            ->where('course_id', $course_id)->get()
            ->get();*/
    }
}
