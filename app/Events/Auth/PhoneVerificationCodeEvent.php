<?php

namespace App\Events\Auth;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PhoneVerificationCodeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $verification_code;
    public $phone;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($verification_code, $phone)
    {
        $this->verification_code = $verification_code;
        $this->phone = $phone;
    }
}
