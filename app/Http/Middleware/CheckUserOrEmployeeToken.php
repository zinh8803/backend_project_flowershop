<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserOrEmployeeToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $user = $request->user();

    if ($user instanceof User || $user instanceof Employee) {
        return $next($request);
    }

    return response()->json([
        'status' => 403,
        'message' => 'Không có quyền truy cập',
    ], 403);
}

}
