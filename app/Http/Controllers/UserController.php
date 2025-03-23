<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role_User;
use Illuminate\Validation\Rule;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     /**
    *    @OA\Get(
    *     path="/api/users",
    *     summary="Lấy danh user",
    *   tags={"users"},
    *     @OA\Response(response=200, description="Danh sách user"),
    * )
    * 
    */
    public function getAllUsers()
    {
        return response()->json([
            'status' => 200,
            'message' => 'All users',
            'data' => UserResource::collection(User::all())
        ], 200);
    }

/**
 * @OA\Post(
 *     path="/api/register",
 *     summary="Đăng ký tài khoản",
 *     description="API để đăng ký tài khoản mới",
 *     tags={"users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"name", "email", "password"},
 *                 @OA\Property(property="name", type="string", example="Nguyen Van A"),
 *                 @OA\Property(property="email", type="string", format="email", example="nguyenvana@example.com"),
 *                 @OA\Property(property="password", type="string", format="password", example="password123"),
 *                
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tạo tài khoản thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=201),
 *             @OA\Property(property="message", type="string", example="User created"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Nguyen Van A"),
 *                 @OA\Property(property="email", type="string", example="nguyenvana@example.com"),
 *                 @OA\Property(property="avatar", type="string", example="assets/avatars/avatar1.jpg"),
 *                 @OA\Property(property="role", type="string", example="user"),
 *                 @OA\Property(property="created_at", type="string", example="2025-03-07 10:00:00"),
 *             ),
 *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Lỗi validation",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="message", type="string", example="Validation error"),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="email", type="array",
 *                     @OA\Items(type="string", example="The email has already been taken.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */



    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        $token = $user->createToken('API Token')->plainTextToken;
    
        return response()->json([
            'status' => 201,
            'message' => 'User created successfully',
            'user' => new UserResource($user),
           
            'token' => $token
        ], 201);
    }

   /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Đăng nhập",
     *     description="API để đăng nhập bằng email và mật khẩu",
     *     tags={"users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string", format="email", example="nguyenvana@example.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="password123")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đăng nhập thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Nguyen Van A"),
     *                 @OA\Property(property="email", type="string", example="nguyenvana@example.com"),
     *                 @OA\Property(property="avatar", type="string", example="assets/avatars/avatar1.jpg"),
     *                 @OA\Property(property="role", type="string", example="user"),
     *                 @OA\Property(property="created_at", type="string", example="2025-03-07 10:00:00")
     *             ),
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Sai tài khoản hoặc mật khẩu",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Account or password is incorrect"),
     *             @OA\Property(property="errors", type="object", nullable=true)
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

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Account or password is incorrect',
                
            ], 401);
        }

        $user->update([
            'is_logged_in' => true,
            'last_login_at' => now()
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'data' => new UserResource($user),
            'token' => $token
        ], 200);
    }

    /**
 * @OA\Post(
 *     path="/api/logout",
 *     summary="Đăng xuất",
 *     description="API để đăng xuất người dùng",
 *     tags={"users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Đăng xuất thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Logged out successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Người dùng không tồn tại",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="User not found"),
 *             @OA\Property(property="errors", type="object", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Dữ liệu không hợp lệ",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="message", type="string", example="Validation error"),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="id", type="array",
 *                     @OA\Items(type="string", example="The id field is required.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */


    public function logout(Request $request)
    {
    $validatedData = $request->validate([
        'id' => 'required|integer|exists:users,id'
    ]);

    $user = User::find($request->id);

    if (!$user) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found',
            'errors' => null
        ], 404);
    }

    // Xóa tất cả token của user
    $user->tokens()->delete();

    // Cập nhật trạng thái đăng xuất
    $user->update(['is_logged_in' => false]);

    return response()->json([
        'status' => 200,
        'message' => 'Logged out successfully'
    ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
/**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     summary="Cập nhật thông tin user (không bao gồm ảnh)",
 *     tags={"users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID của user cần cập nhật"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={ "email"},
 *             @OA\Property(property="name", type="string", example="Nguyễn Văn A"),
 *             @OA\Property(property="email", type="string", format="email", example="nguyenvana@example.com"),
 *             @OA\Property(property="password", type="string", example="123456"),
 *             @OA\Property(property="role", type="string", example="admin")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User updated successfully"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */
public function update(Request $request, $id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['status' => 404, 'message' => 'User not found'], 404);
    }

    $validatedData = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'email' => [
            'sometimes',
            'required',
            'email',
            Rule::unique('users')->ignore($id),
        ],
        'password' => 'sometimes|required|min:6',
        'role' => 'sometimes|required|string'
    ]);

    if ($request->has('password')) {
        $validatedData['password'] = Hash::make($request->password);
    }

    $user->update($validatedData);

    return response()->json([
        'status' => 200,
        'message' => 'User updated successfully',
        'data' => new UserResource($user),
    ]);
}

/**
 * @OA\Post(
 *     path="/api/users/update-avatar/{id}",
 *     summary="Cập nhật avatar của user",
 *     tags={"users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID của user cần cập nhật avatar"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"avatar"},
 *                 @OA\Property(property="avatar", type="string", format="binary")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Avatar updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Avatar updated successfully"),
 *             @OA\Property(property="avatar_url", type="string", example="assets/avatars/user123.jpg")
 *         )
 *     )
 * )
 */
public function updateAvatar(Request $request, $id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['status' => 404, 'message' => 'User not found'], 404);
    }

    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($user->avatar && file_exists(public_path($user->avatar))) {
        unlink(public_path($user->avatar));
    }

    $image = $request->file('avatar');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('assets/avatar_image'), $imageName);
    $avatarPath = 'assets/avatar_image/' . $imageName;

    $user->update(['avatar' => $avatarPath]);

    return response()->json([
        'status' => 200,
        'message' => 'Avatar updated successfully',
        'avatar_url' => asset($avatarPath),
    ]);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
