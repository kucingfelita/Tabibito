<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Batas waktu pembayaran
    |--------------------------------------------------------------------------
    |
    | Production: gunakan CHECKOUT_PAYMENT_TIMEOUT_HOURS (default 6).
    | Testing: set CHECKOUT_PAYMENT_TIMEOUT_MINUTES=1 (mengabaikan jam).
    |
    */
    'payment_timeout_hours' => (int) env('CHECKOUT_PAYMENT_TIMEOUT_HOURS', 6),
    'payment_timeout_minutes' => env('CHECKOUT_PAYMENT_TIMEOUT_MINUTES'),
];
