<?php
namespace App\Contracts;

interface HttpContact{
    function http_get($url,$header,$body);
    function http_post($url,$header,$body);
}
