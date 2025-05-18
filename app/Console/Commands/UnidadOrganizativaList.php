<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class UnidadOrganizativaList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unidad-organizativa-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = google_client_console();
        $service = new \Google_Service_Directory($client);

        $optParams = [];

        try {

            $results = $service->orgunits->listOrgunits('my_customer', $optParams);

            if (count($results->getOrganizationUnits()) == 0) {
                echo "no se hallaron.\n";

            } else {

                echo "unidades organizativas:\n";

                foreach ($results->getOrganizationUnits() as $orgUnit) {
                    printf("%s (%s)\n", $orgUnit->getName(), $orgUnit->getOrgUnitPath());
                }
            }
        } catch (Exception $e) {
            echo 'error ---> '.$e->getMessage();
        }
    }
}
