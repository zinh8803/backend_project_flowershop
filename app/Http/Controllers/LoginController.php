<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

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

            $token = $user->createToken('User token',['user']);
            $token->accessToken->expires_at = now()->addDays(7);
            $token->accessToken->save();
            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'data' => new UserResource($user),
                'token' => $token->plainTextToken
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
            $token = $employee->createToken('Employee token',['Employee']);
            $token->accessToken->expires_at = now()->addDays(7);
            $token->accessToken->save();
            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'data' => new EmployeeResource($employee),
                'token' => $token->plainTextToken
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Account or password is incorrect',
        ], 401);
    }


        /**
     * @OA\Get(
     *     path="/api/user/profile",
     *     summary="Lấy thông tin người dùng đăng nhập",
     *     description="Trả về thông tin người dùng dựa trên token đã đăng nhập",
     *     operationId="getUserProfile",
     *     tags={"Auth"},
     *      security={ {"bearerAuth":{}} }, 
     *     @OA\Response(
     *         response=200,
     *         description="Lấy thông tin người dùng thành công",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Lấy thông tin người dùng thành công"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Nguyễn Văn A"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-11T14:30:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-11T15:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Không có quyền truy cập",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */

     public function profile(Request $request)
     {
         $accessToken = $request->bearerToken();
     
         if (!$accessToken) {
             return response()->json([
                 'status' => 401,
                 'message' => 'Token không tồn tại',
             ], 401);
         }
     
         $token = PersonalAccessToken::findToken($accessToken);
     
         if (!$token) {
             return response()->json([
                 'status' => 401,
                 'message' => 'Token không hợp lệ',
             ], 401);
         }
     
         $user = $token->tokenable;
     
         if ($user instanceof \App\Models\User) {
             return response()->json([
                 'status' => 200,
                 'message' => 'Thông tin người dùng',
                 'data' => new UserResource($user),
             ]);
         }
     
         if ($user instanceof \App\Models\Employee) {
             return response()->json([
                 'status' => 200,
                 'message' => 'Thông tin nhân viên',
                 'data' => new EmployeeResource($user),
             ]);
         }
     
         return response()->json([
             'status' => 403,
             'message' => 'Không xác định loại người dùng',
         ], 403);
     }

    



    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Đăng xuất",
     *     description="Đăng xuất người dùng bằng cách hủy token hiện tại",
     *     tags={"Authentication"},
     *    security={ {"bearerAuth":{}} }, 
     *     @OA\Response(
     *         response=200,
     *         description="Đăng xuất thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Người dùng chưa đăng nhập hoặc token không hợp lệ",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $user->currentAccessToken()->delete();

        $user->update(['is_logged_in' => false]);

        return response()->json([
            'status' => 200,
            'message' => 'Logged out successfully',
        ], 200);
    }

}
