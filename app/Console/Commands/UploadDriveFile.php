<?php

namespace App\Console\Commands;

use Exception;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Console\Command;

class UploadDriveFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upload-drive-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'uploads a file to Google Drive to admin account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $googleClient = google_client_console();

        $fileName = 'uberapp.jpg'; // funciona desde storage/app/uberapp.jpg
        $filePath = storage_path('app/'.$fileName);

        if (! file_exists($filePath)) {
            $this->error("no hay archivo en la ruta: {$filePath}");

            return 1;
        }

        $DriveService = new Google_Service_Drive($googleClient);

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
        ]);

        try {
            $result = $DriveService->files->create($fileMetadata, [
                'data' => file_get_contents($filePath),
                'mimeType' => mime_content_type($filePath),
                'uploadType' => 'multipart',
            ]);

            $permission = new \Google_Service_Drive_Permission();
            $permission->setType('anyone');
            $permission->setRole('reader');

            $DriveService->permissions->create($result->id, $permission);

            $this->info("File uploaded successfully: {$result->id}");

        } catch (Exception $e) {
            $this->error('Error during file upload: '.$e->getMessage());

            return 1;
        }

    }
}
