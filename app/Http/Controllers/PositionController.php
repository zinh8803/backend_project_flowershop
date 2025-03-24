<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionResource;
use App\Models\Position;
use App\Services\PositionService;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $positionService;
    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }
    /**
     * @OA\Get(
     *     path="/api/positions",
     *     summary="Lấy danh sách vị trí",
     *     tags={"Positions"},
     *     @OA\Response(response=200, description="Danh sách vị trí")
     * )
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'List of all positions',
            'data' => $this->positionService->getAllPositions()
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
     *     path="/api/positions",
     *     summary="Thêm mới vị trí",
     *     tags={"Positions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Quản lý"),
     *             @OA\Property(property="description", type="string", example="Quản lý chung")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Vị trí đã được tạo")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $this->positionService->createPosition($validated)
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        //
    }
}
