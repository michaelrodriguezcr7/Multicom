<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxiesCustom extends Middleware
{
    /**
     * Confiar en todos los proxies (como Render).
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * Usar todos los encabezados relacionados con proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
