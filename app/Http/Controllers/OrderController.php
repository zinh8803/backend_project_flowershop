<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     /**
    *    @OA\Get(
    *     path="/api/Order",
    *     summary="Lấy danh don hang",
    *   tags={"Order"},
    *     @OA\Response(response=200, description="Danh sách don hang"),
    * )
    * 
    */
    public function index()
    {
        $orders = Order::with(['discount', 'orderItems.product'])->get();
        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách đơn hàng thành công',
            'data' => OrderResource::collection($orders),
        ],200);
    }

    /**
     * @OA\Get(
     *     path="/api/Order/User",
     *     summary="Lấy danh sách đơn hàng của người dùng",
     *     tags={"Order"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách đơn hàng thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Lấy danh sách đơn hàng của người dùng thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user_id", type="integer", example=1),
     *                     @OA\Property(property="total_price", type="number", example=500000),
     *                     @OA\Property(property="status", type="string", example="pending"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-17T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-17T10:00:00Z"),
     *                     @OA\Property(
     *                         property="discount",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="code", type="string", example="SUMMER20"),
     *                         @OA\Property(property="percent", type="integer", example=20)
     *                     ),
     *                     @OA\Property(
     *                         property="order_items",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="order_id", type="integer", example=1),
     *                             @OA\Property(property="product_id", type="integer", example=3),
     *                             @OA\Property(property="quantity", type="integer", example=2),
     *                             @OA\Property(
     *                                 property="product",
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=3),
     *                                 @OA\Property(property="name", type="string", example="Hoa hồng đỏ"),
     *                                 @OA\Property(property="price", type="number", example=250000),
     *                                 @OA\Property(property="image", type="string", example="https://example.com/images/rose.jpg")
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token không hợp lệ",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Unauthorized - Token không hợp lệ")
     *         )
     *     )
     * )
     */


    public function getOrderByUser(Request $request)
    {
        $user = $request->user();
    
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized - Token không hợp lệ',
            ], 401);
        }
    
        $orders = Order::with(['discount', 'orderItems.product'])
            ->where('user_id', $user->id)->latest()
            ->get();
    
        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách đơn hàng của người dùng thành công',
            'data' => OrderResource::collection($orders),
        ]);
    }
        /**
     * @OA\Get(
     *     path="/api/Order/detail={id}",
     *     summary="Lấy chi tiết đơn hàng theo ID",
     *     tags={"Order"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của đơn hàng",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy thông tin đơn hàng thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Lấy thông tin đơn hàng thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="total_price", type="number", example=500000),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-17T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-17T10:00:00Z"),
     *                 @OA\Property(
     *                     property="discount",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="code", type="string", example="SUMMER20"),
     *                     @OA\Property(property="percent", type="integer", example=20)
     *                 ),
     *                 @OA\Property(
     *                     property="order_items",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="order_id", type="integer", example=1),
     *                         @OA\Property(property="product_id", type="integer", example=3),
     *                         @OA\Property(property="quantity", type="integer", example=2),
     *                         @OA\Property(
     *                             property="product",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=3),
     *                             @OA\Property(property="name", type="string", example="Hoa hồng đỏ"),
     *                             @OA\Property(property="price", type="number", example=250000),
     *                             @OA\Property(property="image", type="string", example="https://example.com/images/rose.jpg")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy đơn hàng",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Không tìm thấy đơn hàng")
     *         )
     *     )
     * )
     */

    public function getOrderdetailById($id){
        $order = Order::with(['discount', 'orderItems.product'])
        ->where('id', $id)->first();

        if(!$order){
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy đơn hàng',
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Lấy thông tin đơn hàng thành công',
            'data' => $order,
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
     *     path="/api/Order",
     *     summary="Tạo đơn hàng với size và color",
     *     tags={"Order"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="discount_id", type="integer", nullable=true, example=2),
     *             @OA\Property(property="name", type="string", example="Nguyễn Văn A"),
     *             @OA\Property(property="email", type="string", example="nguyenvana@gmail.com"),
     *             @OA\Property(property="phone_number", type="string", example="0123456789"),
     *             @OA\Property(property="address", type="string", example="123 Đường ABC, TP.HCM"),
     *             @OA\Property(property="payment_method", type="string", example="cash"),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="product_id", type="integer", example=3),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="size_id", type="integer", example=1),
     *                     @OA\Property(
     *                         property="color_ids",
     *                         type="array",
     *                         @OA\Items(type="integer", example=1)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tạo đơn hàng thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Tạo đơn hàng thành công"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Lỗi validate")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'discount_id' => 'nullable|integer|exists:discounts,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.size_id' => 'required|integer|exists:sizes,id',
            'products.*.color_ids' => 'required|array|min:1',
            'products.*.color_ids.*' => 'integer|exists:colors,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'payment_method' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $total_price = 0;
            $order_items = [];

            foreach ($request->products as $product) {
                $productModel = Product::find($product['product_id']);
                $size = Size::find($product['size_id']);
                $colorCount = count($product['color_ids']);

                $discount_price = $productModel->price;
                $product_discount = ProductDiscount::where('product_id', $productModel->id)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();
                if ($product_discount) {
                    $discount_price *= (1 - ($product_discount->percentage / 100));
                }

                $priceWithSize = $discount_price * (1 + ($size->price_modifier / 100));
                $priceWithColors = $priceWithSize * (1 + ($colorCount * 5 / 100));
                $item_total_price = $priceWithColors * $product['quantity'];
                $total_price += $item_total_price;

                $order_items[] = [
                    'product' => $productModel,
                    'quantity' => $product['quantity'],
                    'final_price' => $priceWithColors,
                    'original_price' => $productModel->price,
                    'size_id' => $product['size_id'],
                    'color_ids' => $product['color_ids'],
                ];
            }

            $discountAmount = 0;
            if ($request->discount_id) {
                $discount = Discount::find($request->discount_id);
                if ($discount) {
                    $discountAmount = $discount->type === 'percentage'
                        ? ($total_price * $discount->value) / 100
                        : $discount->value;
                }
            }

            $final_price = max(0, $total_price - $discountAmount);

            $order = Order::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'total_price' => $final_price,
                'payment_method' => $request->payment_method,
                'discount_id' => $request->discount_id,
                'status' => 'pending',
            ]);

            foreach ($order_items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['original_price'],
                    'final_price' => $item['final_price'],
                    'size_id' => $item['size_id'],
                ]);

                foreach ($item['color_ids'] as $colorId) {
                    DB::table('order_item_color')->insert([
                        'order_item_id' => $orderItem->id,
                        'color_id' => $colorId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $item['product']->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Tạo đơn hàng thành công',
                'data' => new OrderResource($order),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'message' => 'Lỗi xử lý đơn hàng',
                'error' => $e->getMessage()
            ], 500);
        }
    }
 


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/Order/{id}/status",
     *     summary="Cập nhật trạng thái đơn hàng",
     *     tags={"Order"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"employee_id", "status"},
     *             @OA\Property(property="employee_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="completed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Cập nhật thành công")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy đơn hàng"
     *     )
     * )
     */

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'employee_id' => 'required_if:status,completed|integer|exists:employees,id',
        ]);
    
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy đơn hàng',
            ], 404);
        }
    
        $order->update(['status' => $request->status]);
    
        if ($request->status === 'completed') {
            $invoice = Invoice::create([
                'order_id' => $order->id,
                'employee_id' => $request->employee_id,
                'total_price' => $order->total_price,
                'payment_method' => $order->payment_method,
            ]);
        }
    
        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật thành công',
        ]);
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
