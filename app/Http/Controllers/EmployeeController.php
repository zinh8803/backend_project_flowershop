<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
    *@OA\SecurityScheme(
    *securityScheme="bearerAuth",
    *type="http",
    *scheme="bearer",
    *bearerFormat="JWT"
    *)
    */
    protected $employeeService;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('register');
       // $this->middleware('check.employee');
    }
    /**
     * @OA\Get(
     *     path="/api/employees",
     *     summary="Lấy danh sách nhân viên",
     *     tags={"Employees"},
     *     security={ {"bearerAuth":{}} },  
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách nhân viên"
     *     )
     * )
     */
    
    public function index()
    {
        $employees = Employee::all();
        return response()->json([
            'status' => 200,
            'data' => EmployeeResource::collection($employees)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/employees/register",
     *     summary="Thêm nhân viên mới",
     *     tags={"Employees"},
     *     security={ {"bearerAuth":{}} },  
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","position_id"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="123456"),
     *             @OA\Property(property="address", type="string", example="123 Street"),
     *             @OA\Property(property="phone_number", type="string", example="0123456789"),
     *             @OA\Property(property="position_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Nhân viên được tạo thành công",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Employee created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *                 @OA\Property(property="address", type="string", example="123 Street"),
     *                 @OA\Property(property="phone_number", type="string", example="0123456789"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-24 10:00:00")
     *             ),
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6',
            'position_id' => 'required|exists:positions,id',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);

    
        $employee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'position_id' => $request->position_id,
                'address' => $validated['address'] ?? null,
                'phone_number' => $validated['phone_number'] ?? null,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
            'data' => new EmployeeResource($employee),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/api/employees/{id}",
     *     summary="Cập nhật thông tin nhân viên",
     *     description="API để cập nhật thông tin của nhân viên dựa trên id",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID của nhân viên cần cập nhật",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Nguyen Van B"),
     *             @OA\Property(property="email", type="string", format="email", example="nguyenb@example.com"),
     *             @OA\Property(property="position_id", type="integer", example=2),
     *             @OA\Property(property="address", type="string", example="123 Main Street"),
     *             @OA\Property(property="phone_number", type="string", example="123456789")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Nhân viên cập nhật thành công",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Employee updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Nguyen Van B"),
     *                 @OA\Property(property="email", type="string", example="nguyenb@example.com"),
     *                 @OA\Property(property="position_id", type="integer", example=2),
     *                 @OA\Property(property="address", type="string", example="123 Main Street"),
     *                 @OA\Property(property="phone_number", type="string", example="123456789"),
     *                 @OA\Property(property="created_at", type="string", example="2025-03-07 10:00:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-03-07 10:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nhân viên không tìm thấy",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Employee not found")
     *         )
     *     )
     * )
     */

    public function update(Request $request,$id)
    {
        $employee = Employee::find($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'position_id' => 'required|exists:positions,id',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);
        if(!$employee){
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found',
            ], 404);
        }
        $employee->update($validated);
        return response()->json([
            'status' => 200,
            'message' => 'Employee updated successfully',
            'data' => new EmployeeResource($employee),
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if(!$employee){
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found',
            ], 404);
        }
        $employee->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Employee deleted successfully',
        ], 200);
    }
}
