<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '1271536119:AAGbvsGaO2h2Hn4CgSf3vR91Lh8xb2G-RvA/webhook',
    ];
}
