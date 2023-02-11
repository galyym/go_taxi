<?php

namespace App\Listeners\Auth;

use App\Events\Auth\PhoneVerificationCodeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhoneVerificationCodeListener
{


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PhoneVerificationCodeEvent $event)
    {
        $data = [
            'login' => (string)config('services.smsc.login'),
            'psw' => (string)config('services.smsc.password'),
            'phones' => (string)$event->phone,
            'mes' => "Ваш код: " . $event->verification_code
        ];

        $sendCode = Http::get("https://smsc.kz/sys/send.php", $data);
    }
}
