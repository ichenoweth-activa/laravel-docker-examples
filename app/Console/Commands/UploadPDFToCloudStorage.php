<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Console\Command;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
class UploadPDFToCloudStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upload-pdf-to-cloud-storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'crea un pdf en base a unos parametros y lo intenta subir a cloud storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $course = Course::where('id', '9c092810-92d1-4859-8c5b-4980d9c4c6dd')->first();


        $archivo = $this->getTemplatePath($course->category);

        $pdf = new Fpdi('L', 'mm','letter');
        $pdf->AddPage();
        $pdf->setSourceFile($archivo);
        $template = $pdf->importPage(1);
        $pdf->useImportedPage($template);
        $pdf->SetFont('Helvetica');
        $pdf->setFontSize(17);
        $pdf->SetTextColor(0, 0, 0);

        $mid_x = 140;
        $text = "CRISTINA FRANCO AMAYA";
        $pdf->Text($mid_x - ($pdf->GetStringWidth($text) / 2), 102, $text);


        $tempPath = storage_path('app/temp_diploma_' . uniqid() . '.pdf');
        $pdf->Output('F', $tempPath);


        $storagePath = 'diplomas/' . basename($tempPath);
        $cloudPath = Storage::disk('gcs')->putFileAs('diplomas', new \Illuminate\Http\File($tempPath), basename($tempPath));


        $publicUrl = Storage::disk('gcs')->url($cloudPath);
        $this->info("metodo 1 -  archivo subido  a: " . $publicUrl);


        //2
        $content = $pdf->Output('S');
        $filename = 'diplomas/diploma_' . uniqid() . '.pdf';
        Storage::disk('gcs')->put($filename, $content);
        $this->info("metodo 2 - archivo subido  a: " . $publicUrl);


//
//        //3
//        $pdf->Output('F', $tempPath);
//        $cloudPath = Storage::disk('gcs')->putFile('diplomas', new \Illuminate\Http\File($tempPath));




        unlink($tempPath);
    }//handle


    private function getTemplatePath($category)
    {
        switch ($category) {
            case 'sitios_web':
                return storage_path('app/constancia sitio web.pdf');
            case 'ia':
                return storage_path('app/constancia inteligencia artificial.pdf');
            case 'apps_moviles':
                return storage_path('app/constancia diseño de aplicaciones.pdf');
            case 'robotica':
                return storage_path('app/constancia robotica.pdf');
            default:
                return null;
        }
    }//getTemplatePath

}
