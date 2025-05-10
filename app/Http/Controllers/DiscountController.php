<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use App\Models\DiscountCondition;
use Carbon\Carbon;
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
     * @OA\Post(
     * path="/api/discounts/check",
     * summary="Kiểm tra hiệu lực của mã giảm giá",
     * description="API để kiểm tra xem một mã giảm giá có hợp lệ để áp dụng cho đơn hàng hay không.",
     * tags={"Discounts"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"code", "order_total"},
     * @OA\Property(property="code", type="string", example="SALE50"),
     * @OA\Property(property="order_total", type="number", format="float", example=100.00)
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Mã giảm giá hợp lệ",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Mã giảm giá hợp lệ"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="type", type="string", example="percentage"),
     * @OA\Property(property="value", type="number", format="float", example=20)
     * )
     * )
     * ),
     * @OA\Response(
     * response=400,
     * description="Mã giảm giá không hợp lệ",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Mã giảm giá không tồn tại")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Lỗi validate dữ liệu",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object",
     * @OA\Property(property="code", type="array", @OA\Items(type="string", example="The code field is required.")),
     * @OA\Property(property="order_total", type="array", @OA\Items(type="string", example="The order total field is required."))
     * )
     * )
     * )
     * )
     */
    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_total' => 'required|numeric|min:0',
        ]);

        $code = $request->input('code');
        $orderTotal = $request->input('order_total');
        $now = Carbon::now();

        $discount = Discount::where('code', $code)
            ->with('condition')
            ->first();

        if (!$discount) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không tồn tại'], 400);
        }

        if ($discount->start_date && $now->lt($discount->start_date)) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá chưa đến thời gian áp dụng'], 400);
        }

        if ($discount->end_date && $now->gt($discount->end_date)) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá đã hết hạn'], 400);
        }

        if ($discount->usage_limit !== null && $discount->usage_count >= $discount->usage_limit) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá đã hết số lần sử dụng'], 400);
        }

        if ($discount->condition && $discount->condition->min_order_total !== null && $orderTotal < $discount->condition->min_order_total) {
            return response()->json(['status' => 'error', 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã'], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Mã giảm giá hợp lệ',
            'data' => [
                'id'=> $discount->id,
                'type' => $discount->type,
                'value' => $discount->value,
            ],
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
 /**
 * @OA\Post(
 * path="/api/discounts",
 * summary="Tạo mã giảm giá mới",
 * description="API tạo mã giảm giá mới với thông tin chi tiết và điều kiện",
 * tags={"Discounts"},
 * @OA\RequestBody(
 * required=true,
 * @OA\MediaType(
 * mediaType="multipart/form-data",
 * @OA\Schema(
 * required={"code", "type", "value", "start_date", "end_date"},
 * @OA\Property(property="code", type="string", example="SALE50"),
 * @OA\Property(property="type", type="string", enum={"fixed", "percentage"}, example="percentage"),
 * @OA\Property(property="value", type="number", format="float", example=20),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-03-10"),
 * @OA\Property(property="end_date", type="string", format="date", example="2025-03-20"),
 * @OA\Property(property="usage_limit", type="integer", example=100),
 * @OA\Property(property="usage_count", type="integer", example=0),
 * @OA\Property(property="min_order_total", type="number", format="float", example=50.00),
 * )
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="Mã giảm giá được tạo thành công",
 * @OA\JsonContent(
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="message", type="string", example="Discount created successfully"),
 * @OA\Property(property="data", type="object",
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="code", type="string", example="SALE50"),
 * @OA\Property(property="type", type="string", example="percentage"),
 * @OA\Property(property="value", type="number", format="float", example=20),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-03-10"),
 * @OA\Property(property="end_date", type="string", format="date", example="2025-03-20"),
 * @OA\Property(property="usage_count", type="integer", example=0),
 * @OA\Property(property="usage_limit", type="integer", example=100),
 * @OA\Property(property="discount_condition", type="object", nullable=true,
 * @OA\Property(property="min_order_total", type="number", format="float", example=50.00),
 * ),
 * ),
 * ),
 * ),
 * @OA\Response(
 * response=422,
 * description="Lỗi validate dữ liệu",
 * @OA\JsonContent(
 * @OA\Property(property="status", type="integer", example=422),
 * @OA\Property(property="message", type="string", example="The given data was invalid."),
 * @OA\Property(property="errors", type="object",
 * @OA\Property(property="code", type="array", @OA\Items(type="string", example="The code has already been taken.")),
 * @OA\Property(property="end_date", type="array", @OA\Items(type="string", example="The end date must be after start date.")),
 * @OA\Property(property="min_order_total", type="array", @OA\Items(type="string", example="The min order total must be a number.")),
 * ),
 * ),
 * )
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
            'usage_limit' => 'nullable|integer|min:0',
            'usage_count' => 'nullable|integer|min:0',
            'min_order_total' => 'nullable|numeric|min:0',
        ]);

        // Tạo mã giảm giá
        $discount = Discount::create($request->only([
            'code',
            'type',
            'value',
            'start_date',
            'end_date',
            'usage_limit',
            'usage_count',
        ]));

        // Tạo điều kiện giảm giá nếu có
        if ($request->has('min_order_total')) {
            DiscountCondition::create([
                'discount_id' => $discount->id,
                'min_order_total' => $request->input('min_order_total'),
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Discount created successfully',
            'data' => new DiscountResource($discount->load('condition')),
        ], 200);
    }

    /**
     * Display the specified resource.
     */

 /**
 * @OA\Get(
 *     path="/api/discounts/code={code}",
 *     summary="Lấy thông tin chi tiết code",
 *     description="Trả về thông tin chi tiết của một mã giảm giá",
 *     tags={"Discounts"},
 *     @OA\Parameter(
 *         name="code",
 *         in="path",
 *         required=true,
 *         description="Mã giảm giá cần tìm",
 *         @OA\Schema(type="string", example="SALE20")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lấy thông tin code thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Lấy thông tin code thành công"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="code", type="string", example="SALE20"),
 *                 @OA\Property(property="type", type="string", example="percentage"),
 *                 @OA\Property(property="value", type="number", format="float", example=20),
 *                 @OA\Property(property="start_date", type="string", format="date-time", example="2024-03-07T14:30:00Z"),
 *                 @OA\Property(property="end_date", type="string", format="date-time", example="2024-04-07T14:30:00Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy code",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Code not found"),
 *             @OA\Property(property="errors", type="string", nullable=true)
 *         )
 *     )
 * )
 */


    public function show($code)
    {
        $discount = Discount::where('code',$code)->first();
        if(!$discount){
            return response()->json([
                'status' => 404,
                'message' => 'not found',
            ],404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Discount find successfully',
            'data' => new DiscountResource($discount)
        ], 200);
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
