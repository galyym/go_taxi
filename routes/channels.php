<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('orderChannel', function ($user, $order) {
    Log::info('DEBUG:', [$order, $user]);
});
