<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ExitSurvey;
use Barryvdh\DomPDF\Facade\Pdf;

class ExitSurveyController extends Controller
{
    public function download(User $user)
    {
        // Verificar permisos
        // Asume que la política de autorización se maneja en middleware o aquí.
        // Pero dado que desde Filament ya se filtra la visibilidad del botón, aquí reforzamos.
        // Solo RH Corp y Admin deberían ver esto según requerimiento.

        $canDownload = auth()->check() && (
            auth()->user()->hasRole('RH Corp') ||
            auth()->user()->hasRole('Administrador')||
            auth()->user()->hasRole('RH')
        );

        if (!$canDownload) {
             abort(403, 'No tiene permisos para descargar este documento.');
        }

        $survey = ExitSurvey::where('user_id', $user->id)->first();

        if (!$survey) {
             abort(404, 'Encuesta de salida no encontrada para este usuario.');
        }

        $questions = ExitSurvey::getQuestionsMap();

        $pdf = Pdf::loadView('pdf.exit_survey', [
            'user' => $user,
            'survey' => $survey,
            'questions' => $questions
        ]);

        $pdf->setPaper('a4', 'portrait');

        // Usamos stream para que el navegador decida si abrir o descargar
        // Si se quiere forzar descarga, usar download()
        return $pdf->stream('Entrevista_Salida_' . $user->name . '.pdf');
    }
}
