<?php

namespace App\Mail\Fronted;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class CustomerSupportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $filePaths;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $filePaths)
    {
        $this->data = $data;
        $this->filePaths = $filePaths;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Customer support - ' . $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.customer-support',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachmentArray = [];
        foreach ($this->filePaths  as $value) {
            // array_push($attachmentArray, Attachment::fromPath($value->getRealPath())->as($value->getClientOriginalName()));
            array_push($attachmentArray, $value);
        }
    
        return $attachmentArray;
    }
}
