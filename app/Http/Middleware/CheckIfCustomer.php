<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->user_type === 'customer') {
            return $next($request);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
