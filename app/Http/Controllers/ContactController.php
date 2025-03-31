<?php

namespace App\Http\Controllers;

use Anhskohbo\NoCaptcha\NoCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            'g-recaptcha-response' => 'required|captcha',
        ]);

        \Log::info('Token recibido en el backend:', ['g-recaptcha-response' => $request->input('g-recaptcha-response')]);

        // Verificar reCAPTCHA
        $response = \Anhskohbo\NoCaptcha\Facades\NoCaptcha::verifyResponse($request->input('g-recaptcha-response'));

        if (!$response) {
            return back()->withErrors(['recaptcha_token' => '¡Actividad sospechosa detectada!'])->withInput();
        }

        try {
            // Enviar el correo
            Mail::to('braugustorh@gmail.com')->send(new ContactFormMail($request->all()));

            // Redirigir con mensaje de éxito
            \Log::info('Mensaje enviado con éxito');

            return back()->with('success', '¡Mensaje enviado con éxito!');

        } catch (\Exception $e) {
            // Loguear el error
            \Log::error('Error al enviar el correo: ' . $e->getMessage());

            // Redirigir con mensaje de error
            return back()->withErrors(['email_error' => 'Ocurrió un error al enviar el mensaje. Inténtalo de nuevo.']);
        }
    }
}
