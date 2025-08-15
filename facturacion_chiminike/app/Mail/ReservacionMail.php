<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservacion;
    public $pdf;

    public function __construct($reservacion, $pdf)
    {
        $this->reservacion = $reservacion;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->markdown('emails.reservacion')
            ->subject('Confirmación de Reservación - Museo Chiminike')
            ->attachData($this->pdf->output(), 'reservacion.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
