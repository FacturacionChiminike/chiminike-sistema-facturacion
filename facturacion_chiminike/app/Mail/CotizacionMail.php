<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\PDF;

class CotizacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cotizacion;
    public $pdf;

    public function __construct($cotizacion, PDF $pdf)
    {
        $this->cotizacion = $cotizacion;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this
            ->subject('Cotización de Evento - ' . ($this->cotizacion['nombre_evento'] ?? ''))
            ->view('emails.cotizacion') // tu vista HTML de correo
            ->attachData($this->pdf->output(), 'cotizacion.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
