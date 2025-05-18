<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Actions\Project\ExportProjectToPdf;
class ExportProjectPdfCommand extends Command
{

    protected $signature = 'project:export-pdf {projectId}';
    protected $description = 'exporta el resumen del proyecto a PDF';


    //php artisan project:export-pdf 7c2a4de3-c391-433e-80d1-19f0cae65378
    public function handle()
    {
        $projectId = $this->argument('projectId');

        $exporter = new ExportProjectToPdf();
//test

        $path = $exporter->handle($projectId);

        $this->info("PDF generado exitosamente: {$path}");
    }
}
