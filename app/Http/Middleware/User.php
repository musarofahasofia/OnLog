<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class User
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->status?->status === 'new') {
            return redirect()->route('password.secure');
        }

        if (auth()->check() && auth()->user()->role === 'user') {
            return $next($request);
        }

        abort(404);
    }
}
