<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */


      /**
    *    @OA\Get(
    *     path="/api/discounts",
    *     summary="Lấy danh sách giảm giá",
    *   tags={"Discounts"},
    *     @OA\Response(response=200, description="Danh sách hoa"),
    * )
    * 
    */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'message' => 'Discounts retrieved successfully',
            'data' => DiscountResource::collection(Discount::all())
        ],200);
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
 *     path="/api/discounts",
 *     summary="Tạo mã giảm giá mới",
 *     description="API tạo mã giảm giá mới với thông tin chi tiết",
 *     tags={"Discounts"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"code", "type", "value", "start_date", "end_date"},
 *                 @OA\Property(property="code", type="string", example="SALE50"),
 *                 @OA\Property(property="type", type="string", enum={"fixed", "percentage"}, example="percentage"),
 *                 @OA\Property(property="value", type="number", format="float", example=20),
 *                 @OA\Property(property="start_date", type="string", format="date", example="2025-03-10"),
 *                 @OA\Property(property="end_date", type="string", format="date", example="2025-03-20"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mã giảm giá được tạo thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Discount created successfully"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="SALE50"),
 *                 @OA\Property(property="type", type="string", example="percentage"),
 *                 @OA\Property(property="value", type="number", format="float", example=20),
 *                 @OA\Property(property="start_date", type="string", format="date", example="2025-03-10"),
 *                 @OA\Property(property="end_date", type="string", format="date", example="2025-03-20"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Lỗi validate dữ liệu",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="code", type="array", @OA\Items(type="string", example="The code has already been taken.")),
 *                 @OA\Property(property="end_date", type="array", @OA\Items(type="string", example="The end date must be after start date.")),
 *             ),
 *         ),
 *     )
 * )
 */


    public function store(Request $request)
    {
       $request->validate([
        'code' => 'required|string|unique:discounts',
        'type' => 'required|in:fixed,percentage',
        'value' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        ]);

        $discount = Discount::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Discount created successfully',
            'data' => new DiscountResource($discount)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   /**
 * @OA\Post(
 *     path="/api/discounts/{id}",
 *     summary="Cập nhật thông tin mã giảm giá",
 *     description="API cập nhật thông tin của một mã giảm giá",
 *     tags={"Discounts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của mã giảm giá cần cập nhật",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"code", "type", "value", "start_date", "end_date"},
 *                 @OA\Property(property="code", type="string", example="SALE50"),
 *                 @OA\Property(property="type", type="string", enum={"fixed", "percentage"}, example="percentage"),
 *                 @OA\Property(property="value", type="number", format="float", example=20),
 *                 @OA\Property(property="start_date", type="string", format="date", example="2025-03-10"),
 *                 @OA\Property(property="end_date", type="string", format="date", example="2025-03-20"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mã giảm giá được cập nhật thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Discount updated successfully"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="SALE50"),
 *                 @OA\Property(property="type", type="string", example="percentage"),
 *                 @OA\Property(property="value", type="number", format="float", example=20),
 *                 @OA\Property(property="start_date", type="string", format="date", example="2025-03-10"),
 *                 @OA\Property(property="end_date", type="string", format="date", example="2025-03-20"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy mã giảm giá",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Discount not found"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Lỗi validate dữ liệu",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="code", type="array", @OA\Items(type="string", example="The code has already been taken.")),
 *                 @OA\Property(property="end_date", type="array", @OA\Items(type="string", example="The end date must be after start date.")),
 *             ),
 *         ),
 *     )
 * )
 */



    public function update(Request $request,$id)
    {
       $discount = Discount::find($id);
       if(!$discount){
        return response()->json([
            'status' => 404,
            'message' => 'Discount not found',
        ], 404);
        }
        $request->validate([
            'code' => 'required|string|unique:discounts,code,'.$discount->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $discount->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Discount updated successfully',
            'data' => new DiscountResource($discount)
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
      /**
 * @OA\Delete(
 *     path="/api/discounts/{id}",
 *     summary="Xóa sản phẩm",
 *     description="API để xóa một sản phẩm khỏi hệ thống.",
 *     tags={"Discounts"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của sản phẩm cần xóa",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Xóa sản phẩm thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Xóa sản phẩm thành công"),
 *             @OA\Property(property="data", type="null"),
 *             @OA\Property(property="errors", type="null")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy sản phẩm",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Không tìm thấy sản phẩm"),
 *             @OA\Property(property="data", type="null"),
 *             @OA\Property(property="errors", type="null")
 *         )
 *     )
 * )
 */
    public function destroy($id)
    {
       
       $discount = Discount::find($id);
        if(!$discount){
            return response()->json([
                'status' => 404,
                'message' => 'Discount not found',
            ], 404);
        }
        $discount->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Discount deleted successfully',
        ], 200);
    }
}
