<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateCalendarEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-calendar-event';

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
        $client = google_client_console();
        // $client->setSubject('cristina.franco@g.nive.la'); no sirve
        $calendarId = 'primary';
        $calendar = new \Google_Service_Calendar($client);

        $event = new \Google_Service_Calendar_Event([
            'summary' => 'Evento el 15 de febrero',
            'location' => 'Ubicación',
            'description' => 'aquí va la descripción',
            'start' => [
                'dateTime' => '2024-02-15T10:00:00-06:00',
                'timeZone' => 'America/Mexico_City',
            ],
            'end' => [
                'dateTime' => '2024-02-15T14:00:00-06:00',
                'timeZone' => 'America/Mexico_City',
            ],
            'attendees' => [
                ['email' => 'cristina.franco@g.nive.la'],
                ['email' => 'cecilia.marin@g.nive.la'],
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60],
                    ['method' => 'popup', 'minutes' => 24 * 60],
                ],
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
            ],
        ]);

        $options = [
            'conferenceDataVersion' => 1,
        ];

        $event = $calendar->events->insert('primary', $event, $options);
        $this->info($event->getId());
        //$event->getId(); //id del evento del calendar
        //$event->getHangoutLink()  liga del meet

        $events = $calendar->events->listEvents($calendarId);
        foreach ($events->getItems() as $event) {
            echo $event->getSummary().' - '.$event->getStart()->dateTime."\n";
        }
    }
}
