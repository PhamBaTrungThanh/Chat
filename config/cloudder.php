<?php

list($scheme, $cloudName, $apiKey, $apiSecret) = array_values(parse_url(env('CLOUDINARY_URL')));
return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API configuration
    |--------------------------------------------------------------------------
    |
    | Before using Cloudinary you need to register and get some detail
    | to fill in below, please visit cloudinary.com.
    |
    */

    'cloudName'  => env('CLOUDINARY_CLOUD_NAME', $cloudName),
    'baseUrl'    => env('CLOUDINARY_BASE_URL', 'http://res.cloudinary.com/'.env('CLOUDINARY_CLOUD_NAME', $cloudName)),
    'secureUrl'  => env('CLOUDINARY_SECURE_URL', 'https://res.cloudinary.com/'.env('CLOUDINARY_CLOUD_NAME', $cloudName)),
    'apiBaseUrl' => env('CLOUDINARY_API_BASE_URL', 'https://api.cloudinary.com/v1_1/'.env('CLOUDINARY_CLOUD_NAME', $cloudName)),
    'apiKey'     => env('CLOUDINARY_API_KEY', $apiKey),
    'apiSecret'  => env('CLOUDINARY_API_SECRET', $apiSecret),

    'scaling'    => [
        'format' => 'png',
        'width'  => 256,
        'height' => 256,
        'crop'   => 'fit',
        'effect' => null
    ],

];
