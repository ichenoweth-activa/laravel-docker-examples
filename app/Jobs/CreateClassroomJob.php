<?php

namespace App\Jobs;

use App\Models\Project;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateClassroomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id;
    public $idProyect;
    public $project;

    /**
     * Create a new job instance.
     */
    public function __construct($id, $idProyect)
    {
        $this->id = $id;
        $this->idProyect = $idProyect;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = \App\Models\User::findOrFail($this->id);
            $this->project = Project::with(['metodologias', 'campoFormativos', 'projectSession.materials', 'disciplinas'])
                ->where('id', $this->idProyect)
                ->firstOrFail();
            //dd($this->project);
            //$user = \App\Models\User::where('email', $user->email)->first();
            $client = google_client_console_user_logged($user);
            $classroom = new \Google_Service_Classroom($client);
            $newCourse = new \Google_Service_Classroom_Course(
                [
                    'name' => $this->project->nombre,
                    'section' => $this->project->nivel,
                    'description' => 'Classroom',
                    'room' => $this->project->grado_escolar,
                    'ownerId' => $user->email,
                    'courseState' => 'ACTIVE',
                ]
            );
            $newCourse = $classroom->courses->create($newCourse);
            $this->project->classroom_id = $newCourse->id;
            $this->project->save();
        } catch (\Google_Service_Exception $e) {
            Bugsnag::notifyException($e);
        }
    }
}
