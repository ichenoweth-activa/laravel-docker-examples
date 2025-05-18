<?php

namespace App\Console\Commands;

use Google_Service_Drive_Permission;
use Illuminate\Console\Command;

class CreateGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-google-sheet';

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
        $service = new \Google_Service_Sheets($client);
        $spreadsheetProperties = new \Google_Service_Sheets_SpreadsheetProperties();
        $nombreSheet = 'Sheet de prueba';
        $spreadsheetProperties->setTitle($nombreSheet);
        $sheets = [];
        $sheetProperties = new \Google_Service_Sheets_SheetProperties();
        $sheetProperties->setTitle('Prueba prueba'); ////TAB INICIAL
        $sheet = new \Google_Service_Sheets_Sheet();
        $sheet->setProperties($sheetProperties);
        $sheets[] = $sheet;

        $requestBody = new \Google_Service_Sheets_Spreadsheet();
        $requestBody->setProperties($spreadsheetProperties);
        $requestBody->setSheets($sheets);

        try {
            $response = $service->spreadsheets->create($requestBody);
            $url = 'https://docs.google.com/spreadsheets/d/'.$response->getSpreadsheetId().'/edit';
            $body = new \Google_Service_Sheets_ValueRange([
                'values' => [
                    'ID Classroom', //Id del curso copia creado
                    'Nombre (obligatorio)', //Dato que se asignó en la creación
                    'Sección', //Dato que se asignó en la creación
                    'Descripción (obligatorio)', //Dato que se asignó en la creación
                    'Aula', //Dato que se asignó en la creación
                    'Correo Profesores (obligatorio,separar por , )', //En blanco
                ],
            ]);
            $params = [
                'valueInputOption' => 'RAW',
            ];
            $RequestBody = new Google_Service_Drive_Permission;
            $DriveServ = new \Google_Service_Drive($client);
            $RequestBody->setType('anyone');
            //    $RequestBody->setRole('reader');
            $RequestBody->setRole('writer');
            $DriveServ->permissions->create($response->getSpreadsheetId(), $RequestBody);
            $range = 'A1:G1';
            $result = $service->spreadsheets_values->update($response->getSpreadsheetId(), $range, $body, $params);
            $this->info($url);
        } catch (\Exception $e) {

            $this->info('ERROR : '.$e->getMessage());
        }

    }
}
