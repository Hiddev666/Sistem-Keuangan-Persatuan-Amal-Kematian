<?php

namespace App\Services;

use Midtrans\Config;

class MidtransService
{
    public static function init()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
