<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Support\Facades\App;

class TrustProxiesCustom extends Middleware
{
    public function __construct()
    {
        // Solo confiar en proxies si estamos en producción
        $this->proxies = App::environment('production') ? '*' : null;
    }
}
