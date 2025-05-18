<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UnidadOrganizativaCrear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unidad-organizativa-crear';

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
        //edu.tecnolochias.org customer id  C01yw0o3k
        //g.nive.la     customer id         C04ietk5t

        $client = google_client_console();
        $service = new \Google_Service_Directory($client);
        $newOrgUnitpath = new \Google_Service_Directory_OrgUnit([
            'name' => 'Tecnolochicas', //   campaña-invierno24
            'description' => 'Contexto nombre de la campaña',
            'parentOrgUnitPath' => '/', //   /Tecnolochicas

        ]);
        $newOrgUnitpath = $service->orgunits->insert('my_customer', $newOrgUnitpath);

    }
}
