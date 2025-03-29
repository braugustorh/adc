<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;


class ContactController extends Controller
{
    public function submit(Request $request) {
        // Validar datos
        //dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'terminal' => 'nullable|string',
            'message' => 'required|string',
            'recaptcha_token' => 'required|string',
        ]);

        // Verificar reCAPTCHA
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->recaptcha_token,
        ]);

        $responseData = $response->json();
    /*
        if (!$responseData['success'] || $responseData['score'] < 0.5) {
            return back()->withErrors(['recaptcha_token' => '¡Actividad sospechosa detectada!'])->withInput();
        }
    */
        // Enviar correo
        try {
            Mail::to('braugustorh@gmail.com')->send(new ContactFormMail($request->all()));
        } catch (\Exception $e) {
            \Log::error("Error al enviar correo: " . $e->getMessage());
            return back()->with('error', 'Error al enviar el mensaje');
        }
        return back()->with('success', '¡Mensaje enviado con éxito!');
    }
}
