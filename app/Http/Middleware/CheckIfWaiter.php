<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfWaiter
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->user_type === 'waiter') {
            return $next($request);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
