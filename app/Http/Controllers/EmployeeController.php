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
     *             @OA\Property(property="token", type="string", example="xyz123abc456")
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
        $token = $employee->createToken('Employee Token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
            'data' => new EmployeeResource($employee),
            'token' => $token
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
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
