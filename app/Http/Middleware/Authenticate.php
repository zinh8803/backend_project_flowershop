<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
   

     protected function unauthenticated($request, array $guards)
     {
         throw new AuthenticationException('Unauthenticated.', $guards);
     }
 
     /**
      * Chặn chuyển hướng đến trang login, luôn trả về JSON nếu không có token.
      */
     protected function redirectTo(Request $request): ?string
     {
         if ($request->expectsJson()) {
             abort(response()->json([
                 'status' => 'error',
                 'message' => 'Unauthorized. Token is required.',
                 'data' => null
             ], 401));
         }
         
         return null; // Chỉ dành cho web, nhưng API sẽ không bị lỗi redirect.
     }

}
