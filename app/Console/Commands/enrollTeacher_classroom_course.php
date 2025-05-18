<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class enrollTeacher_classroom_course extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enroll-teacher_classroom_course';

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
        $client = google_client_console();
        $classroom = new \Google_Service_Classroom($client);
        $userEnroll = new \Google_Service_Classroom_Teacher([
            'userId' => 'curso1dp@edu.tecnolochicas.org',
        ]);                                         //id course google
        $classroom->courses_teachers->create('754892053200', $userEnroll);
    }
}
