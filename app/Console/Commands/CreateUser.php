<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba crear un usuario con los permisos del usuario logueado actual';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //funcionando
        $googleClient = google_client_console();

        //  $client = \App\Helpers\Client::get($usuario);
        $service = new \Google_Service_Directory($googleClient);
        $user = new \Google_Service_Directory_User();
        $this->name = new \Google_Service_Directory_UserName;
        $this->name->familyName = 'karla';
        $this->name->givenName = 'flores';
        //$user->orgUnitPath = '/Tecnolochicas/campana_2023';
        $user->setName($this->name);

        $password_temporal = base64_encode(uniqid());
        $this->passwordTemporal = $password_temporal;
        // $user->password = $password_temporal;
        $user->password = 'Karla12345';
        $user->primaryEmail = 'c'.($this->consecutivo()).'@g.nive.la';
        $user->changePasswordAtNextLogin = true;
        $this->primaryEmail = $user->primaryEmail;
        $user = $service->users->insert($user);
        log::debug(' USUARIO CREADO----> ');
        $this->info($user->primaryEmail);
        $this->info($user->password);

    }

    private function consecutivo($userId = 0)
    {
        $string = sha1(uniqid().date('YmdHis'));
        $string = substr($string, 0, 10);

        return $string;
    }
}
