<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EvaluationAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    // Recibimos la entidad (User o Candidate) y el token
    public function __construct(
        public $evaluable,
        public string $token
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitación a Evaluación Psicométrica - SEDYCO',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.evaluation-assigned', // Esta vista la crearemos abajo
        );
    }
}
