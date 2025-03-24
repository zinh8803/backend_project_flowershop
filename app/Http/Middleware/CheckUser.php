<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->tokenCan('User Token')) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}