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

        if (!$responseData['success'] || $responseData['score'] < 0.5) {
            return back()->withErrors(['recaptcha_token' => '¡Actividad sospechosa detectada!'])->withInput();
        }

        // Enviar correo
        Mail::to('braugustorh@gmail.com')->send(new ContactFormMail($request->all()));

        return back()->with('success', '¡Mensaje enviado con éxito!');
    }
}
