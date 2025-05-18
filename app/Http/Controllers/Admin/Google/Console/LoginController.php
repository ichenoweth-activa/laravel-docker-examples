<?php

namespace App\Http\Controllers\Admin\Google\Console;

use App\Http\Controllers\Controller;
use App\Models\Google\Console\Client as ConsoleClient;
use App\Models\Google\Console\User as ConsoleUser;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        //    public function login(ConsoleClient $clientConfiguration)

        $clientConfiguration = ConsoleClient::where('id',1)->first();

      //  dd($clientConfiguration->client_data);
        $client = new \Google_Client();

        $client->setAuthConfig($clientConfiguration->client_data);
        $client->setRedirectUri(route('google.users.callback'));
        $client->setApplicationName('Impulsa');
        $client->setScopes([
            'openid',
            \Google_Service_Oauth2::USERINFO_PROFILE,
            \Google_Service_Oauth2::USERINFO_EMAIL,

            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_FILE,

            \Google_Service_HangoutsChat::CHAT_SPACES,
            \Google_Service_HangoutsChat::CHAT_MEMBERSHIPS,

            \Google_Service_Classroom::CLASSROOM_COURSES,
            \Google_Service_Classroom::CLASSROOM_ROSTERS,
            \Google_Service_Classroom::CLASSROOM_PROFILE_EMAILS,
            \Google_Service_Classroom::CLASSROOM_STUDENT_SUBMISSIONS_STUDENTS_READONLY,
            \Google_Service_Classroom::CLASSROOM_ANNOUNCEMENTS,
            \Google_Service_Classroom::CLASSROOM_TOPICS,
            \Google_Service_Classroom::CLASSROOM_COURSEWORKMATERIALS,
            \Google_Service_Classroom::CLASSROOM_COURSEWORK_STUDENTS,

            \Google_Service_Calendar::CALENDAR,
            \Google_Service_Calendar::CALENDAR_EVENTS,
            \Google_Service_Directory::ADMIN_DIRECTORY_USER,
            \Google_Service_Directory::ADMIN_DIRECTORY_ORGUNIT,

            \Google_Service_Docs::DOCUMENTS

        ]);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->setState($clientConfiguration->id);

        $authUrl = $client->createAuthUrl();

         //  dd($client);

        return redirect()->to($authUrl);
    }

    public function callback(Request $request)
    {
        $client = new \Google_Client();
        $clientConfiguration = ConsoleClient::find($request->state);
        $client->setAuthConfig($clientConfiguration->client_data);
        $client->setRedirectUri(route('google.users.callback'));

        $client->setApplicationName('analiza-test');
        $client->setScopes([
            'openid',
            \Google_Service_Oauth2::USERINFO_PROFILE,
            \Google_Service_Oauth2::USERINFO_EMAIL,

            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_FILE,

            \Google_Service_Classroom::CLASSROOM_COURSES,
            \Google_Service_Classroom::CLASSROOM_ROSTERS,
            \Google_Service_Classroom::CLASSROOM_PROFILE_EMAILS,
            \Google_Service_Classroom::CLASSROOM_STUDENT_SUBMISSIONS_STUDENTS_READONLY,
            \Google_Service_Classroom::CLASSROOM_ANNOUNCEMENTS,
            \Google_Service_Classroom::CLASSROOM_TOPICS,
            \Google_Service_Classroom::CLASSROOM_COURSEWORKMATERIALS,
            \Google_Service_Classroom::CLASSROOM_COURSEWORK_STUDENTS,

            \Google_Service_HangoutsChat::CHAT_SPACES,
            \Google_Service_HangoutsChat::CHAT_MEMBERSHIPS,

            \Google_Service_Calendar::CALENDAR,
            \Google_Service_Calendar::CALENDAR_EVENTS,
            \Google_Service_Directory::ADMIN_DIRECTORY_USER,

            \Google_Service_Docs::DOCUMENTS
        ]);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        $client->fetchAccessTokenWithAuthCode($request->code);
        $accessToken = $client->getAccessToken();
        $client->setAccessToken($accessToken);

        $google_oauthV2 = new \Google_Service_Oauth2($client);
        $guser = $google_oauthV2->userinfo->get();

        $consoleUserData = [
            'console_client_id' => 1,
            'name' => $guser->name,
            'google_id' => $guser->id,
            'email' => $guser->email,
            'provider_token' => $accessToken['access_token'],
            'provider_refresh_token' => $accessToken['refresh_token'],
            'provider_expires_in' => $accessToken['expires_in'],
            'provider_created' => $accessToken['created'],
            'scopes' => json_encode(explode(' ', (string) $accessToken['scope'])),
        ];

     //   dd($consoleUserData);

        ConsoleUser::updateOrCreate(
            [
                'email' => $guser->email,
            ],
            $consoleUserData
        );

        //return redirect('https://tecnolochicas.estudiolab.app');
        return redirect()->route('project.index');

    }
}
