<?php

namespace App\Livewire;

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
    public function submitForm()
    {
        $this->validate();

        // Validar reCAPTCHA v3 con Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY')??'6Lc8ywMrAAAAAMohSS_wpCtrqk9hVR3ljqaIiM5I',
            'response' => $this->recaptchaToken
        ]);

        $body = $response->json();

        if (!$body['success'] || $body['score'] < 0.5) {
            session()->flash('error', 'Verificación de seguridad fallida.');
            return;
        }

        // Enviar el correo
        Mail::to('braugustorh@gmail.com')->send(new ContactFormMail($this->name, $this->company, $this->email, $this->message));

        // Resetear los campos
        $this->reset(['name', 'company', 'email', 'message', 'recaptchaToken']);

        session()->flash('success', 'Tu mensaje ha sido enviado correctamente.');
    }

    #[On('setRecaptchaToken.{token}')]
    public function setRecaptchaToken($token)
    {
        $this->recaptchaToken = $token;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
