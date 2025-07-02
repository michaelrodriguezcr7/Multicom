<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Support\Facades\App;

class TrustProxiesCustom extends Middleware
{
    /**
     * Usar todos los encabezados relacionados con proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    public function __construct()
    {
        // Solo confiar en proxies si estamos en producción
        $this->proxies = App::environment('production') ? '*' : null;
    }
}
