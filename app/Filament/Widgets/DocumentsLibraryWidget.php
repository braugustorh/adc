<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class DocumentsLibraryWidget extends Widget
{
    protected static string $view = 'filament.widgets.documents-library';

    protected static ?string $heading = 'Biblioteca de Documentos';

    protected static ?int $sort = 5; // Posición del widget en el dashboard

    // Hacer el widget visible solo para usuarios con roles RH y RH Corp
    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['RH', 'RH Corp']);
    }
    // Obtener datos para el widget (ejemplo)
    public function getViewData(): array
    {
        // Aquí puedes agregar la lógica para obtener documentos
        // Por ejemplo, desde una tabla de documentos o archivos
        return [
            'totalDocuments' => 1, // Ejemplo
            'recentDocuments' => [
                ['name' => 'Protocolo para prevenir, atender y erradicar la violencia laboral',
                    'path' => 'protocolo_violencia.pdf',
                    'description' => 'Este es un protocolo para prevenir y erradicar la violencia en tu centro de trabajo.',
                    'type' => 'PDF',
                    'size' => '1.2 MB'],

            ],
            'categories' => [
                'Políticas' => 1,
                'Formatos' => 0,
               // 'Manuales' => 5,
            ]
        ];
    }
    public function downloadDocument(string $name){
        $storagePath = storage_path('app/documents/' . $name);
        if (file_exists($storagePath)) {
            return response()->download($storagePath, $name);
        }else{
            return response()->json(['error' => 'Documento no encontrado'], 404);
        }

    }
}
