<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies;

class CustomTrustProxies extends TrustProxies
{
    protected $proxies = '*';
    protected $headers = Request::HEADER_X_FORWARDED_FOR;
}
