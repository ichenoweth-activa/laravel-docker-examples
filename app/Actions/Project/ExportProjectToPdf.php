<?php
namespace App\Actions\Project;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class ExportProjectToPdf
{
    public function handle(string $projectId): string
    {
        $project = Project::with([
            'disciplinas',
            'campoFormativos',
            'projectSession' => function ($query) {
                $query->select('project_id', 'instrucciones_docente');
            },
        ])->findOrFail($projectId);

        $data = [
            'project' => $project,
        ];

        $pdf = Pdf::loadView('pdf.project_summary', $data);
        $filename = 'project_' . $project->id . '_summary.pdf';
        $path = storage_path("app/public/exports/{$filename}");

        file_put_contents($path, $pdf->output());

        return $path;
    }
}
