<?php

namespace App\Http\Controllers;

use App\Models\PsychometricEvaluation;
use Illuminate\Http\Request;

class PublicEvaluationController extends Controller
{
    public function landing($token)
    {
        // 1. Validar que el token exista en general (para seguridad básica)
        // Buscamos cualquier registro con ese token, solo para ver si es válido.
        $exists = PsychometricEvaluation::where('access_token', $token)->exists();

        if (!$exists) {
            abort(404, 'Enlace de evaluación no válido.');
        }

        // 2. Usar nuestra función maestra para buscar LA SIGUIENTE pendiente
        $nextEvaluation = PsychometricEvaluation::getNextPendingByToken($token);
            // 3. ESCENARIO A: Ya no hay pendientes -> ¡Felicidades!
        if (!$nextEvaluation) {
            return view('evaluations.process-finished');
        }

            // 4. Validar expiración (si aplica)
        if ($nextEvaluation->expires_at && $nextEvaluation->expires_at->isPast()) {
            abort(403, 'Este enlace de evaluación ha expirado.');
        }

        // 5. ESCENARIO B: Hay examen pendiente -> Mostrar Landing
        // Calculamos cuántas faltan para mostrarle "Te faltan 2 de 5"
        $pendingCount = PsychometricEvaluation::countPendingByToken($token);

        // Obtenemos el nombre del evaluado usando la relación polimórfica
        $nameEvaluated = $nextEvaluation->evaluable->name;

        return view('evaluations.welcome', [
            'evaluation' => $nextEvaluation,
            'nameEvaluated'=> $nameEvaluated,
            'token' => $token,
            'pendingCount' => $pendingCount
        ]);
    }
}
