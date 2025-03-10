<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDiscountResource;
use App\Models\ProductDiscount;
use Illuminate\Http\Request;

class ProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     /**
    *    @OA\Get(
    *     path="/api/product-discounts",
    *     summary="Lấy danh sách giam gia",
    *   tags={"Products-discount"},
    *     @OA\Response(response=200, description="Danh sách giam gia"),
    * )
    * 
    */
    public function index()
    {
       $discounts = ProductDiscount::all();
       return response()->json([
        'status' => 200,
        'message' => 'All discounts',
        'data' => ProductDiscountResource::collection($discounts)
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
 * @OA\Post(
 *     path="/api/product-discounts",
 *     summary="Tạo giảm giá cho sản phẩm",
 *     description="API giúp admin thêm giảm giá cho một sản phẩm trong khoảng thời gian cụ thể",
 *     tags={"Products-discount"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"product_id", "percentage", "start_date", "end_date"},
 *                 @OA\Property(property="product_id", type="integer", example=1, description="ID của sản phẩm"),
 *                 @OA\Property(property="percentage", type="integer", example=20, description="Phần trăm giảm giá"),
 *                 @OA\Property(property="start_date", type="string", format="date-time", example="2025-03-15 10:00:00"),
 *                 @OA\Property(property="end_date", type="string", format="date-time", example="2025-03-15 12:00:00"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Giảm giá được tạo thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Discount created"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="product_id", type="integer", example=1),
 *                 @OA\Property(property="percentage", type="integer", example=20),
 *                 @OA\Property(property="start_date", type="string", format="date-time", example="2025-03-15 10:00:00"),
 *                 @OA\Property(property="end_date", type="string", format="date-time", example="2025-03-15 12:00:00"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Dữ liệu không hợp lệ",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="message", type="string", example="Validation Error"),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="product_id", type="array",
 *                     @OA\Items(type="string", example="The product_id field is required.")
 *                 ),
 *                 @OA\Property(property="percentage", type="array",
 *                     @OA\Items(type="string", example="The percentage must be a number.")
 *                 ),
 *             ),
 *         ),
 *     )
 * )
 */


    public function store(Request $request)
    {
       $request->validate([
        'product_id' => 'required',
        'percentage' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
       $discount = ProductDiscount::create($request->all());
         return response()->json([
          'status' => 200,
          'message' => 'Discount created',
          'data' => new ProductDiscountResource($discount)
         ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductDiscount $productDiscount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductDiscount $productDiscount)
    {
        //
    }

  /**
 * @OA\post(
 *     path="/api/product-discounts/{id}",
 *     summary="Cập nhật giảm giá cho sản phẩm",
 *     description="API giúp admin chỉnh sửa thông tin giảm giá của sản phẩm",
 *     tags={"Products-discount"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID của giảm giá cần cập nhật"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"product_id", "percentage", "start_date", "end_date"},
 *                 @OA\Property(property="product_id", type="integer", example=1, description="ID của sản phẩm"),
 *                 @OA\Property(property="percentage", type="integer", example=30, description="Phần trăm giảm giá"),
 *                 @OA\Property(property="start_date", type="string", format="date-time", example="2025-03-20 09:00:00"),
 *                 @OA\Property(property="end_date", type="string", format="date-time", example="2025-03-20 11:00:00"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cập nhật giảm giá thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Discount updated"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="product_id", type="integer", example=1),
 *                 @OA\Property(property="percentage", type="integer", example=30),
 *                 @OA\Property(property="start_date", type="string", format="date-time", example="2025-03-20 09:00:00"),
 *                 @OA\Property(property="end_date", type="string", format="date-time", example="2025-03-20 11:00:00"),
 *             ),
 *         ),
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $discount = ProductDiscount::find($id);
        if(!$discount){
            return response()->json([
                'status' => 404,
                'message' => 'Discount not found'
            ],404);
        }
        $request->validate([
            'product_id' => 'required',
            'percentage' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $discount->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Discount updated',
            'data' => new ProductDiscountResource($discount)
        ],200);
    }

/**
 * @OA\Delete(
 *     path="/api/product-discounts/{id}",
 *     summary="Xóa giảm giá của sản phẩm",
 *     description="API giúp admin xóa giảm giá của sản phẩm",
 *     tags={"Products-discount"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID của giảm giá cần xóa"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Xóa giảm giá thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Discount deleted"),
 *         ),
 *     )
 * )
 */

    public function destroy($id)
    {
        $discount = ProductDiscount::find($id);
        if(!$discount){
            return response()->json([
                'status' => 404,
                'message' => 'Discount not found'
            ],404);
        }
        $discount->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Discount deleted'
        ],200);
    }
}
