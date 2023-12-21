<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class StudentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $approved;

    public function __construct($approved)
    {
        $this->approved = $approved;
    }

    public function build()
    {
        $status = $this->approved ? 'Aprobada' : 'Rechazada';

        return $this->subject("Solicitud de registro: $status!")
            ->view('emails.student-mail');
    }
}
