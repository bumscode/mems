<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignInMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;
    private $url;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $url
     */
    public function __construct(User $user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.signin')
            ->from('noway@mems.wtf', "noway@mems.wtf")
            ->to($this->user->email)
            ->with(['url' => $this->url]);
    }
}
