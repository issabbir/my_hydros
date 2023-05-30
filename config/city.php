<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | All configuration of City Bank Payment Gateway found on this config
    |
    */
    "keyPath" => "/var/www/html/ipay_dummy/public/city/createorder.key",
    "caCertificatePath" => "/var/www/html/ipay_dummy/public/city/createorder.crt",

    "userName" => "test",
    "password" => "123456Aa",

    "merchantId" => "11122333",

    "serviceUrlToken" => "https://sandbox.thecitybank.com:7788/transaction/token",
    "serviceUrlCreateOrder" => "https://sandbox.thecitybank.com:7788/transaction/createorder",

    "approveUrl" => "http://localhost:8888/gatewaypayment/city/approve",
    "cancelUrl" => "http://localhost:8888/gatewaypayment/city/approve",
    "declineUrl" => "http://localhost:8888/gatewaypayment/city/approve",


];