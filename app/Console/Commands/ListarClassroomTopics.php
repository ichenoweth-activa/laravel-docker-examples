<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListarClassroomTopics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:listar-classroom-topics';

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

        $pageTokenTopics = null;
        $topics = [];
        do {
            $optParams = [
                'pageSize' => 100,
                'pageToken' => $pageTokenTopics,
            ];

            $results = $classroom->courses_topics->listCoursesTopics($courseId, $optParams);
            $pageTokenTopics = $results->nextPageToken;
            $topics = array_merge($topics, $results->getTopic());
        } while (! empty($pageTokenTopics));
        var_dump($topics);

    }
}
