<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        $address = 'notify@chow420.com';
        $subject = $this->data['subject'];
        $name    = 'Chow420';
        $userarr = $this->data['userarr'];

        return $this
                    ->view('email.newsletter')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    //->with([ 'newsletter_message' => $this->data['message'] ]);
                     ->with([ 'newsletter_message' => $this->data ]);
    }
}
