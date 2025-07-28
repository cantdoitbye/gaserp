<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TourPackageConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bookingData)
    {
        $this->bookingData = $bookingData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Your Tour Package Booking Confirmation',
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
            view: 'emails.tour-package-confirmation',
            with: [               

                'user' => $this->bookingData['user'],
                'tour' => $this->bookingData['tour'],
                'booking' => $this->bookingData['booking'],
                'payment' => $this->bookingData['payment'],
                'rooms' => $this->bookingData['rooms'],
                'travel_date' => $this->bookingData['travel_date'],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}