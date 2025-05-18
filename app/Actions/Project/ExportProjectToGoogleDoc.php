<?php
namespace App\Actions\Project;

use App\Models\Project;
use Google_Service_Docs;
use Google_Service_Docs_Document;
use Google_Service_Docs_Request;

class ExportProjectToGoogleDoc
{
    public function handle(string $projectId, \Google_Client $client): string
    {
        $requests = [];

        $project = Project::with([
            'disciplinas',
            'campoFormativos',
            'projectSession' => fn($q) => $q->select('project_id', 'instrucciones_docente'),
        ])->findOrFail($projectId);

        $docsService = new Google_Service_Docs($client);

        // Crea un nuevo documento
        $document = new Google_Service_Docs_Document([
            'title' => 'Resumen del Proyecto: ' . $project->nombre,
        ]);
        $createdDoc = $docsService->documents->create($document);
        $documentId = $createdDoc->documentId;


        $requests = array_merge($requests, $this->insertText("Resumen del Proyecto: {$project->nombre}\n\n", true));

        $requests = array_merge($requests, $this->insertText("Contenido: {$project->contenido}\n"));
        $requests = array_merge($requests, $this->insertText("Descripción: {$project->descripcion}\n"));

        $requests = array_merge($requests, $this->insertText("Proceso de Desarrollo del Aprendizaje: {$project->proceso_desarrollo_aprendizaje}\n"));
        $requests = array_merge($requests, $this->insertText("Lenguaje: {$project->lenguaje}\n"));
        $requests = array_merge($requests, $this->insertText("Nivel: {$project->nivel}\n"));
        $requests = array_merge($requests, $this->insertText("Producto: {$project->producto}\n"));

        $requests = array_merge($requests, $this->insertText("Subproducto: {$project->subproducto}\n"));
        $requests = array_merge($requests, $this->insertText("Grado Escolar: {$project->grado_escolar}\n"));


        if ($project->disciplinas->isNotEmpty()) {
            $requests = array_merge($requests, $this->insertText("Disciplinas:\n", true));
            foreach ($project->disciplinas as $d) {
                $requests = array_merge($requests, $this->insertText("- {$d->name}\n"));
            }
        }

        if ($project->campoFormativos->isNotEmpty()) {
            $requests = array_merge($requests, $this->insertText("\nCampos Formativos:\n", true));
            foreach ($project->campoFormativos as $c) {
                $requests = array_merge($requests, $this->insertText("- {$c->name}\n"));
            }
        }

        if ($project->projectSession->isNotEmpty()) {
            $requests = array_merge($requests, $this->insertText("\nInstrucciones del Docente:\n", true));
            foreach ($project->projectSession as $session) {
                if ($session->instrucciones_docente) {
                    $requests = array_merge($requests, $this->insertText("- {$session->instrucciones_docente}\n"));
                }
            }
        }

        $docsService->documents->batchUpdate($documentId, new \Google_Service_Docs_BatchUpdateDocumentRequest([
            'requests' => $requests,
        ]));

        return "https://docs.google.com/document/d/{$documentId}/edit";
    }

    private function insertText(string $text, bool $bold = false): array
    {
        $requests = [];

        // Insertar texto
        $requests[] = [
            'insertText' => [
                'location' => ['index' => 1],
                'text' => $text,
            ]
        ];

        // Aplicar negritas (bold) solo si se indica
        if ($bold) {
            $requests[] = [
                'updateTextStyle' => [
                    'range' => [
                        'startIndex' => 1,
                        'endIndex' => 1 + strlen($text)
                    ],
                    'textStyle' => ['bold' => true],
                    'fields' => 'bold'
                ]
            ];
        }

        return $requests;
    }
}
