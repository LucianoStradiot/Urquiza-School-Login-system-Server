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
        $status = $this->approved ? 'Aprobado' : 'Rechazado';

        return $this->subject("Estado de aprobación $status")
            ->view('emails.student-mail');
    }
}
