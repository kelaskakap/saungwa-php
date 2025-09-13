<?php

return [
    'appkey' => env('SAUNGWA_APPKEY', ''),
    'authkey' => env('SAUNGWA_AUTHKEY', ''),
    'base_uri' => env('SAUNGWA_BASEURI', 'https://app.saungwa.com/api'),
    'sandbox' => env('SAUNGWA_SANDBOX', false),
    'guzzle' => [
        // override guzzle options here
    ],
];
