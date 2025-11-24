<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int,string>
     */
    protected $except = [
        // The CSRF token cookie must NOT be encrypted so the client can send
        // the raw token value back in the X-XSRF-TOKEN header.
        'XSRF-TOKEN',
    ];
}
