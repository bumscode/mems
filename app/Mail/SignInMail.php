<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignInMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        private string $email,
        private string $url
    ) {
    }

    public function build()
    {
        return $this->markdown('mail.signin')
            ->from('noway@mems.wtf', "noway@mems.wtf")
            ->to($this->email)
            ->with(['url' => $this->url]);
    }
}
