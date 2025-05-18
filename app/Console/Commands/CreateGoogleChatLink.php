<?php

namespace App\Console\Commands;

use Google_Service_HangoutsChat;
use Illuminate\Console\Command;

class CreateGoogleChatLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-google-chat-link';

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
        $chatService = new Google_Service_HangoutsChat($client);

        $userEmail = 'dennis@g.nive.la';
        try {
            $response = $chatService->spaces->findDirectMessage(['name' => 'users/'.$userEmail]);

            $spaceId = $response->getName();
            $parts = explode('/', (string) $spaceId);
            $stringId = $parts[1];
            $spaceUrl = "https://mail.google.com/chat/u/0/#chat/dm/{$stringId}";

            $this->info('spaceUrl si existe');
            $this->info($spaceUrl);
            echo 'en el try ok';
        } catch (\Exception) {
            echo 'en el catch';
            $space = new \Google_Service_HangoutsChat_Space();
            //$space->setSpaceType('DIRECT_MESSAGE');
            // $space->setType('DM');
            //"message": "Specify a space type of SPACE. Other space types aren't supported.",
            $space->setSpaceType('SPACE');
            $space->setName('CANAL lunes');
            $space->setDisplayName('CANAL LUNES');
            $spaceCreated = $chatService->spaces->create($space);
            $spaceId = $spaceCreated->getName();

            $parts = explode('/', (string) $spaceId);
            $stringId = $parts[1];

            //[,$stringId] = explode("/", $spaceId);

            $membership = new \Google_Service_HangoutsChat_Membership();
            $membership->setName('users/'.$stringId.'/members/bernardo@g.nive.la');
            //  $membership->setName('space/AAAAy9yeSHc');
            $membership->setRole('ROLE_MEMBER');
            $membership->setState('JOINED');

            $userHangouts = new \Google_Service_HangoutsChat_User();
            $userHangouts->setName('users/bernardo@g.nive.la'); //mentora
            $userHangouts->setType('HUMAN');
            $userHangouts->setIsAnonymous(true);
            $membership->setMember($userHangouts);

            $chatService->spaces_members->create('spaces/'.$stringId, $membership);

            $user2Hangouts = new \Google_Service_HangoutsChat_User();
            $user2Hangouts->setName('users/dennis@g.nive.la'); //mentora
            $user2Hangouts->setType('HUMAN');
            $user2Hangouts->setIsAnonymous(true);
            $membership->setMember($user2Hangouts);

            $chatService->spaces_members->create('spaces/'.$stringId, $membership);

            $spaceUrl = "https://mail.google.com/chat/u/0/#chat/space/{$stringId}";

            $this->info($spaceUrl);

        }

        //rafa
        //            {
        //                "name": "spaces/hrG70IAAAAE",
        //  "type": "ROOM",
        //  "spaceThreadingState": "UNTHREADED_MESSAGES",
        //  "spaceType": "DIRECT_MESSAGE",
        //  "spaceHistoryState": "HISTORY_ON"
        //}
        //bernardo
        //            {
        //                "name": "spaces/hgV-uQAAAAE",
        //  "type": "ROOM",
        //  "spaceThreadingState": "UNTHREADED_MESSAGES",
        //  "spaceType": "DIRECT_MESSAGE",
        //  "spaceHistoryState": "HISTORY_ON"
        //}

        //no existe
        //        {
        //            "error": {
        //            "code": 404,
        //    "message": "The specified direct message doesn't exist.",
        //    "status": "NOT_FOUND"
        //  }
        //}

    }
}
