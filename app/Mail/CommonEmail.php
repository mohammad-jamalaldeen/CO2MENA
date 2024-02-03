<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommonEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $subject;
    public $viewPath;
    public $filePaths;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $subject, $viewPath, $filePaths = array(), $fileType='attachment')
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->viewPath = $viewPath;
        $this->filePaths = $filePaths;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->viewPath,
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
            if($this->filePaths == 'attachment')
            {
                array_push($attachmentArray, Attachment::fromPath($value->getRealPath())->as($value->getClientOriginalName())); 
            } else 
            {
                array_push($attachmentArray, $value);    
            }
            
        }
    
        return $attachmentArray;
    }
}
