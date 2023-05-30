<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | All configuration of bKash found on this config
    |
    */
    'username' => 'testdemo',
    'password' => 'test%#de23@msdao',

    'app_key' => '5nej5keguopj928ekcj3dne8p',
    'app_secret' => '1honf6u1c56mqcivtc9ffl960slp4v2756jle5925nbooa46ch62',

    'tokenUrl' => 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/token/grant',
    'createPaymentUrl' => 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/create',
    'executePaymentUrl' => 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/execute',
    'queryPaymentUrl' => 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/query',

    'bkashScriptURL' => 'https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js',

];