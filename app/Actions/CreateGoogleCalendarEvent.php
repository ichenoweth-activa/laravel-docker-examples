<?php

namespace App\Actions;

use DateTime;
use DateTimeZone;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class CreateGoogleCalendarEvent
{
    public function execute(string $studentEmail, string $instructorEmail, string $startTime, string $endTime)
    {
        $startDateTime = new DateTime($startTime, new DateTimeZone('America/Mexico_City'));
        $endDateTime = new DateTime($endTime, new DateTimeZone('America/Mexico_City'));
        $client = google_client_console();
        $calendar = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Evento',
            'location' => 'Ubicación',
            'description' => 'Meet de mentora y alumna',
            'start' => [
                'dateTime' => $startDateTime->format(DateTime::ATOM),
                'timeZone' => 'America/Mexico_City',
            ],
            'end' => [
                'dateTime' => $endDateTime->format(DateTime::ATOM),
                'timeZone' => 'America/Mexico_City',
            ],
            'attendees' => [
                ['email' => $instructorEmail],
                ['email' => $studentEmail],
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

        $options = ['conferenceDataVersion' => 1];

        return $calendar->events->insert('primary', $event, $options);
    }
}
