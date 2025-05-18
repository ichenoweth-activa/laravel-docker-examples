<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FindOrCreateFolderDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:find-or-create-folder-drive';

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
        $googleClient = google_client_console();
        $DriveService = new \Google_Service_Drive($googleClient);

        $folderName = 'RECURSOS_TECNOLOCHICAS';
        $folderId = $this->findOrCreateFolder($DriveService, $folderName);
        $this->info($folderId);
    }

    private function findOrCreateFolder($DriveService, $folderName)
    {
        $response = $DriveService->files->listFiles([
            'q' => "name='{$folderName}' and mimeType='application/vnd.google-apps.folder' and trashed=false",
            'spaces' => 'drive',
            'fields' => 'files(id, name)',
        ]);
        if (count($response->files) == 0) {
            $folder = new \Google_Service_Drive_DriveFile([
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder',
            ]);
            $folder = $DriveService->files->create($folder, ['fields' => 'id']);

            return $folder->id;
        }

        return $response->files[0]->id;
    }
}
