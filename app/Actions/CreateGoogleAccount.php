<?php

namespace App\Actions;

use App\Models\Campaign;
use App\Models\Google\Console\User;

class CreateGoogleAccount
{
    public function execute(string $familyName, string $givenName, string $email, string $passwordTemporal, string $OrgunitPath): \Google\Service\Directory\User
    {

        //        $orgUnitPath = Campaign::query()
        //            ->select('orgunit_path')
        //            ->where('id', $campaignId)
        //            ->first();

        $googleClient = google_client_console();

        $service = new \Google_Service_Directory($googleClient);
        $googleWorkspaceUser = new \Google_Service_Directory_User();
        $googleUserName = new \Google_Service_Directory_UserName();
        $googleUserName->familyName = $familyName;
        $googleUserName->givenName = $givenName;
        //$googleWorkspaceUser->orgUnitPath = $orgUnitPath->orgunit_path;
        //$googleWorkspaceUser->orgUnitPath = "/Mentoras";
        $googleWorkspaceUser->orgUnitPath = $OrgunitPath;

        $googleWorkspaceUser->setName($googleUserName);

        $googleWorkspaceUser->password = $passwordTemporal;

//        $userEmail = User::where('id', 1)->first()->email;
//        $domain = explode('@', $userEmail)[1];

        //$primaryEmail = 'tc_'.strtolower((string) $lettersFromName).($this->consecutivo()).'@'.$domain;
        $googleWorkspaceUser->primaryEmail = $email;
        $googleWorkspaceUser->changePasswordAtNextLogin = true;

        return $service->users->insert($googleWorkspaceUser);
    }

    private function consecutivo(): string
    {
        $shaDate = sha1(uniqid().date('YmdHis'));

        return substr($shaDate, 0, 10);
    }
}
