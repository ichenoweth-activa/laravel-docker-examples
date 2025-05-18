<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function __invoke()
    {
        return Socialite::driver('google')
            ->scopes([
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

            ])
            ->with(['access_type' => 'offline',
                    'include_granted_scopes' => 'true',
                    'prompt' => 'select_account'
            ])
            ->redirect();

    }
}

//../auth/chat.messages.create
