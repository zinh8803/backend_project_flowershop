<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEmployee
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->tokenCan('Employee Token')) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}