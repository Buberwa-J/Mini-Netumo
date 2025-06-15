<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SiteAlertMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public string $alertMessage;
    public string $alertSubject;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $alertMessage, string $alertSubject = 'Site Alert Notification')
    {
        $this->user = $user;
        $this->alertMessage = $alertMessage;
        $this->alertSubject = $alertSubject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->alertSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.site_alert',
            with: [
                'greeting' => 'Hello ' . $this->user->name . ',',
                'alertMessage' => $this->alertMessage,
                'url' => 'http://185.181.11.156/dashboard',
                'salutation' => 'Regards, Mini-Netumo Team',
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
        return [];
    }
}
