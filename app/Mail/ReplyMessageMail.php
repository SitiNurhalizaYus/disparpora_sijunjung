<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $reply;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param string $name Nama pengirim pesan
     * @param string $reply Isi balasan yang akan dikirimkan
     * @param string $subject Subjek balasan pesan
     */
    public function __construct($name, $reply, $subject)
    {
        $this->name = $name;
        $this->reply = $reply;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Balasan dari Dinas Pariwisata Pemuda dan Olahraga Kab. Sijunjung: ' . $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reply_message', // view untuk email balasan
            with: [
                'name' => $this->name,
                'reply' => $this->reply,
                'subject' => $this->subject,
            ]
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
