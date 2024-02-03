<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackupCreateMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $filepathurl;

    /**
     * Create a new message instance.
     */
    public function __construct($data,$filepathurl)
    {
        $this->data = $data;
        $this->filepathurl = $filepathurl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Backup Create Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.backup-create-mail',
            with: [
                'data' => $this->data,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [$this->filepathurl];
    }
}
