<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\ContactFormMail;
use Livewire\Attributes\On;


class ContactForm extends Component
{
    public $name, $company, $email, $message, $recaptchaToken;

    protected $rules = [
        'name' => 'required|max:100',
        'company' => 'required|max:100',
        'email' => 'required|email|max:100',
        'message' => 'required|max:5000',
        'recaptchaToken' => 'required'
    ];
    public function submit()
    {
        $this->validate();

        // Validar reCAPTCHA v3 con Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $this->recaptchaToken
        ]);

        $body = $response->json();

        if (!$body['success'] || $body['score'] < 0.5) {
            session()->flash('error', 'Verificación de seguridad fallida.');
            return;
        }

        try {
            // Enviar el correo
            Mail::to('braugustorh@gmail.com')->send(new ContactFormMail(
                $this->name,
                $this->company,
                $this->email,
                $this->message
            ));

            // Resetear los campos
            $this->reset(['name', 'company', 'email', 'message']);
            session()->flash('success', 'Tu mensaje ha sido enviado correctamente.');

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error en el envío del mensaje.');
            Log::error('Error sending contact form: '.$e->getMessage());
        }
        // Resetear los campos


    }

    #[On('setRecaptchaToken')]
    public function setRecaptchaToken($token)
    {
        Log::info('Si llega aqui');
        $this->recaptchaToken = $token;
        Log::info($this->recaptchaToken);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
