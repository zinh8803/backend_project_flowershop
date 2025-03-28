<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Đăng nhập vào hệ thống",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Đăng nhập thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="data", type="object", 
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="user@example.com"),
 *                 @OA\Property(property="created_at", type="string", example="2022-01-01T00:00:00"),
 *                 @OA\Property(property="updated_at", type="string", example="2022-01-01T00:00:00")
 *             ),
 *             @OA\Property(property="token", type="string", example="user-token-string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Thông tin đăng nhập không chính xác",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Account or password is incorrect")
 *         )
 *     )
 * )
 */



    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Account or password is incorrect',
                ], 401);
            }

            $user->update([
                'is_logged_in' => true,
                'last_login_at' => now()
            ]);

            $token = $user->createToken('User token',['user'])->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'data' => new UserResource($user),
                'token' => $token
            ], 200);
        }

        $employee = Employee::where('email', $request->email)->first();

        if ($employee) {
            if (!Hash::check($request->password, $employee->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Account or password is incorrect',
                ], 401);
            }
            $token = $employee->createToken('Employee token',['Employee'])->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'data' => new EmployeeResource($employee),
                'token' => $token
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Account or password is incorrect',
        ], 401);
    }

}
