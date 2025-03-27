<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Str;

class PasswordController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     summary="Gửi email đặt lại mật khẩu",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Đã gửi email reset password."),
     *     @OA\Response(response=400, description="Email không tồn tại."),
     * )
     */
    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Email không tồn tại trong hệ thống!'
            ], 404);
        }

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
            'status' => 200, 
            'message' => 'Đã gửi email reset password!'
            ], 200)
            : response()->json([
            'status' => 400, 
            'message' => 'Không thể gửi email!'
            ], 400);
        }
    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     summary="Đặt lại mật khẩu mới",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"token", "email", "password", "password_confirmation"},
     *             @OA\Property(property="token", type="string", example="abc123xyz"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Mật khẩu đã được đặt lại thành công."),
     *     @OA\Response(response=400, description="Token không hợp lệ hoặc hết hạn."),
     * )
     */
    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6'
        ]);
    
        if ($validatedData['password'] !== $validatedData['password_confirmation']) {
            return response()->json([
                'status' => 400,
                'message' => 'Mật khẩu xác nhận không khớp'
            ], 400);
        }

        $status = Password::reset(
            $validatedData,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );
        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'status' => 200, 
                'message' => 'Mật khẩu đã được đặt lại thành công!'
            ], 200)
            : response()->json([
                'status' => 400, 
                'message' => 'Mã không hợp lệ hoặc đã hết hạn'
            ], 400);
    }
}
