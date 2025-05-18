<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListClassRoomCourseWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-class-room-course-work';

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
        $courseIdOrigen = '655599786186'; // INTRODUCCION A LAS ESTRUCTURAS DE DATOS
        $courseWork = [];
        $client = google_client_console();
        $classroom = new \Google_Service_Classroom($client);
        $pageTokenCourseWork = null;

        do {
            $optParams = [
                'pageSize' => 100,
                'pageToken' => $pageTokenCourseWork,
                'courseWorkStates' => ['DRAFT', 'PUBLISHED'],
            ];
            $results = $classroom->courses_courseWork->listCoursesCourseWork($courseIdOrigen, $optParams);
            if (count($results) > 0) {
                $courseWork = array_merge($courseWork, $results->getCourseWork());
            }
            $pageTokenCourseWork = $results->nextPageToken;
        } while (! empty($pageTokenCourseWork));

        var_dump($courseWork);

    }
}
