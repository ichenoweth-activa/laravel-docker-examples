<?php


namespace App\Actions;


use App\Mail\InstructorAcceptedMailable;
use App\Models\AdmissionInstructorRequest;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateInstructorGoogleAccount
{

    public function execute(AdmissionInstructorRequest $instructorRequest, string $comment = null): void
    {
        $instructorRequest->load('instructor');
        $createGoogleAccount = new CreateGoogleAccount();
        $passwordTemporal = Str::random(10);
        $OrgunitPath = '/Mentoras';

        $familyName = Str::squish($instructorRequest->instructor->last_name_paternal.' '.$instructorRequest->instructor->last_name_maternal);
        $googleUserEmail = $this->getEmailUser($instructorRequest);

        $googleWorkspaceUser = $createGoogleAccount->execute(
            $familyName,
            $instructorRequest->instructor->names,
            $googleUserEmail,
            $passwordTemporal,
            $OrgunitPath
        );

        $newUser = User::create([
            'email' => $googleWorkspaceUser->primaryEmail,
            'temporal_password' => $passwordTemporal,
            'name' => Str::squish($familyName.' '.$instructorRequest->instructor->names),
            'google_id' => $googleWorkspaceUser->id,
            'accepted_community_rules' => true,
        ]);

        //actualizamos el user id del modelo instructor
        Instructor::where('id', $instructorRequest->instructor_id)
            ->update([
                'user_id' => $newUser->id,
            ]);
        $newUser->syncRoles('instructor');

        $instructorRequest->update([
            'accepted' => true,
            'comments' => $comment,
        ]);

        Mail::to($instructorRequest->instructor->personal_email)->send(
            new InstructorAcceptedMailable($newUser->name, $newUser->email, $newUser->temporal_password)
        );
    }
//Correo electrónico : itshollygurl@gmail.com
    private function getEmailUser(AdmissionInstructorRequest $instructorRequest): string
    {
        [$firstName] = explode(" ", $instructorRequest->instructor->names);
        [$familyNameUser] = explode(" ", $instructorRequest->instructor->last_name_paternal);
        $familyNameUser = str()->squish($familyNameUser);
        [$lastNameUser] = explode(" ", $instructorRequest->instructor->last_name_maternal);
        $lastNameUser = str()->squish($lastNameUser);

        if($lastNameUser !== ''){
            $lastNameUser = Str::substr($lastNameUser, 0, 2);
            return str()->of("{$firstName}.{$familyNameUser}.{$lastNameUser}@edu.tecnolochicas.org")
                ->transliterate()
                ->toString();
        }

        return str()->of("{$firstName}.{$familyNameUser}@edu.tecnolochicas.org")
            ->lower()
            ->transliterate()
            ->toString();
    }
}

