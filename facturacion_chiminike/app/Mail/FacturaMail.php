<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $facturaData;
    public $pdfData;

    public function __construct(array $facturaData, string $pdfData)
    {
        $this->facturaData = $facturaData;
        $this->pdfData     = $pdfData;
    }

    public function build()
    {
        return $this
            ->subject('🧾 Tu Factura Electrónica - Museo Chiminike')
            ->view('emails.factura')
            ->with(['facturaData' => $this->facturaData])
            ->attachData(
                $this->pdfData,
                "Factura_{$this->facturaData['numero_factura']}.pdf",
                ['mime' => 'application/pdf']
            );
    }
}
