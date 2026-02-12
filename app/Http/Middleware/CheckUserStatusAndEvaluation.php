<?php

namespace App\Http\Middleware;

use App\Models\ExitSurvey;
use App\Models\UserTermination;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use pxlrbt\FilamentExcel\FilamentExcelServiceProvider;
use Symfony\Component\HttpFoundation\Response;


class CheckUserStatusAndEvaluation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check()) {
            $user = filament()->auth()->user();
            //Verificamos que el usuario este desactivado
            if ($user->status===0 || !$user->status) {
                //Aqui ya esta desactivado el usuario
                $pendingSurvey = UserTermination::where('user_id', $user->id)
                    ->first();
                if ($pendingSurvey) {
                    $survey= ExitSurvey::where('user_id', $user->id)
                        ->where('status', 'finalizada')
                        ->first();
                    if ($survey){
                        //Aqui ya hizo la encuesta el colaborador y lo regresa al login
                        \Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->flush();
                        $request->session()->regenerateToken();
                       return redirect(filament()->getLoginUrl());
                    }else{
                        //Aqui no ha hecho la encuesta y lo manda a la encuesta
                        //Esto es importante porque no lo va dejar hacer nada mas hasta que haga la encuesta
                        if (!$request->routeIs('filament.pages.exit-survey-page')) {
                            return redirect()->route('filament.pages.exit-survey-page')->withErrors(['data.email' => 'Por favor complete la encuesta de salida para continuar.']);
                        }
                    }

                }
                //else {
//
//                    return redirect()->route('dashboard.login')->with('error', 'No hay encuestas pendientes para completar.');
//                }
            }
        }
        return $next($request);
    }


}
