<?php

namespace App\Jobs;

use App\Mail\SignInMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSignInMail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    public function __construct(
        private string $email,
        private string $url
    ) {
    }


    public function handle()
    {
        Mail::send(new SignInMail($this->email, $this->url));
    }
}
