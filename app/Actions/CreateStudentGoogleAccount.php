<?php


namespace App\Actions;


use App\Mail\StudentAcceptedMailable;
use App\Models\AdmissionStudentRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateStudentGoogleAccount
{
   // public function execute(AdmissionStudentRequest $studentRequest, string $comment = null)
    public function execute(AdmissionStudentRequest $studentRequest, ?string $personalEmail = null, string $comment = null)
    {
        $createGoogleAccount = new CreateGoogleAccount();
        $passwordTemporal = Str::random(10);

        $OrgunitPath = '/Alumnas';

        $familyName = Str::squish($studentRequest->student->lastNamePaternalChild.' '.$studentRequest->student->lastNameMaternalChild);

        $googleEmailUser = $this->getEmailUser($studentRequest);

        $googleWorkspaceUser = $createGoogleAccount->execute(
            $familyName,
            $studentRequest->student->nameChild,
            $googleEmailUser,
            $passwordTemporal,
            $OrgunitPath
        );

        $newUser = User::create([
            'email' => $googleWorkspaceUser->primaryEmail,
            'temporal_password' => $passwordTemporal,
            'name' => Str::squish($familyName.' '.$studentRequest->student->nameChild),
            'google_id' => $googleWorkspaceUser->id,
            'accepted_community_rules' => true,
        ]);
        $newUser->syncRoles('student');

        //actualizamos el user id del modelo student
        Student::query()
            ->where('id', $studentRequest->student_id)
            ->update([
                'user_id' => $newUser->id,
            ]);

        $studentRequest->update([
            'accepted' => true,
            'comments' => $comment,
        ]);

        Mail::to($studentRequest->student->email)
            ->send(
                new StudentAcceptedMailable($newUser->name, $newUser->email, $passwordTemporal)
            );

        if ( !empty($personalEmail) ) {
            Mail::to($personalEmail)
                ->send(new StudentAcceptedMailable($newUser->name, $newUser->email, $passwordTemporal));
        }

    }

    /**
     * @param  AdmissionStudentRequest  $studentRequest
     * @return string @6587
     */
    private function getEmailUser(AdmissionStudentRequest $studentRequest): string
    {
        [$firstName] = explode(" ", $studentRequest->student->nameChild);
        [$familyNameUser] = explode(" ", $studentRequest->student->lastNamePaternalChild);
        $familyNameUser = str()->squish($familyNameUser);
        [$lastNameUser] = explode(" ", $studentRequest->student->lastNameMaternalChild);
        $lastNameUser = str()->squish($lastNameUser);

        if ($lastNameUser !== '') {
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
