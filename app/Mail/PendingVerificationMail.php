<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingVerificationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private string $adminEmail,
        private string $userEmail
    ) {
    }

    public function build()
    {
        return $this->markdown('mail.pending-verification')
            ->from('noway@mems.wtf', "noway@mems.wtf")
            ->to($this->adminEmail)
            ->with(['userEmail' => $this->userEmail]);
    }
}
