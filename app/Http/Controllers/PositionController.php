<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionResource;
use App\Models\Position;
use App\Services\PositionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/positions",
     *     summary="Lấy danh sách vị trí",
     *     tags={"Positions"},
     *    security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Danh sách vị trí")
     * )
     */
    public function index()
    {
        $positions = Position::all();
        return response()->json([
            'status' => 200,
            'message' => 'List of positions',
            'data' => PositionResource::collection($positions)
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
     *   security={{"bearerAuth": {}}},
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

        $position = Position::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Position created successfully',
            'data' => new PositionResource($position),
        ]);
    
    }

    
    /**
     * Display the specified resource.
     */
    /**
 * @OA\Get(
 *     path="/api/positions/{id}",
 *     summary="Lấy thông tin chi tiết của một vị trí",
 *     tags={"Positions"},
 *     security={{"bearerAuth":{}}}, 
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của vị trí cần lấy thông tin",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lấy thông tin vị trí thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Position details"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Manager"),
 *                 @OA\Property(property="description", type="string", example="Quản lý cấp cao")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy vị trí",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Position not found")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
       $position = Position::find($id);
         if(!$position){
              return response()->json([
                'status' => 404,
                'message' => 'Position not found'
              ], 404);
         }
       return response()->json([
           'status' => 200,
            'message' => 'Position details',
           'data' =>new PositionResource($position)
       ]);
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
    /**
     * @OA\Put(
     *     path="/api/positions/{id}",
     *     summary="Cập nhật thông tin vị trí",
     *     tags={"Positions"},
     *     security={{"bearerAuth":{}}}, 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của vị trí cần cập nhật",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Senior Manager"),
     *             @OA\Property(property="description", type="string", example="Quản lý cấp cao")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật vị trí thành công",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Position updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Senior Manager"),
     *                 @OA\Property(property="description", type="string", example="Quản lý cấp cao")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy vị trí",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Position not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request,$id)
    {

        $position = Position::find($id);
        if(!$position){
            return response()->json([
                'status' => 404,
                'message' => 'Position not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $position->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Position updated successfully',
            'data' => new PositionResource($position),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
   /**
     * @OA\Delete(
     *     path="/api/positions/{id}",
     *     summary="Xóa vị trí",
     *     tags={"Positions"},
     *     security={{"bearerAuth":{}}}, 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của vị trí cần xóa",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Xóa vị trí thành công",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Position deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy vị trí",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Position not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $position = Position::find($id);
        if(!$position){
            return response()->json([
                'status' => 404,
                'message' => 'Position not found'
            ], 404);
        }

        $position->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Position deleted successfully',
        ]);
    }

}
