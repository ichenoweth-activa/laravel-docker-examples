<?php

namespace App\Console\Commands;

use App\Actions\Project\ExportProjectToGoogleDoc;
use Illuminate\Console\Command;

class ExportProjectToGoogleDocCommand extends Command
{

    protected $signature = 'project:export-doc';
    protected $description = 'exportar a google docs segun el id de proyecto';


    public function handle()
    {

        //9e6f14fc-c7ad-4390-99c7-ce6473ca6ed6 dennis@activa.la
        //7c2a4de3-c391-433e-80d1-19f0cae65378  eco detectives


//        $projectId = $this->argument('projectId');
//        $userId = $this->argument('userId');

        $user = \App\Models\User::findOrFail("9e6f14fc-c7ad-4390-99c7-ce6473ca6ed6");


        $client = google_client_console_user_logged($user);
        //$client = google_client_console_user_logged($user);

        $url = app(ExportProjectToGoogleDoc::class)->handle("7c2a4de3-c391-433e-80d1-19f0cae65378", $client);

        $this->info("Documento creado: {$url}");


    }
}
