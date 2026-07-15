<?php

namespace App\Mail;

use App\Models\School;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeSchool extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public School $school
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenue sur SchoolManager — Votre espace est prêt !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome-school',
        );
    }
}
