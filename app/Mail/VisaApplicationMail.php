<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;  // This is the correct import

class VisaApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $visaApplication;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($visaApplication)
    {
        // Eager load all the required relationships
        $this->visaApplication = $visaApplication->load([
            'visa',
            'visa.visaType',
            'visa.visaCountry'
        ]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $countryName = $this->visaApplication->visa->visaCountry->name ?? 'Visa';
        return new Envelope(
            subject: $countryName . ' Visa Application - Reference #' . $this->visaApplication->id,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.visa-application-pdf',
        );
    }


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $pdf = PDF::loadView('emails.visa-application-pdf', [
            'visaApplication' => $this->visaApplication
        ]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'visa-application.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
