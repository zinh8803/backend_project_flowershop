<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductDiscount;
use Illuminate\Http\Request;

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
     *     summary="Tạo đơn hàng",
     *     tags={"Order"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="discount_id", type="integer", nullable=true, example=2),
     *                 @OA\Property(property="name", type="string", example="Nguyễn Văn A"),
     *                 @OA\Property(property="email", type="string", example="nguyenvana@gmail.com"),
     *                 @OA\Property(property="phone_number", type="string", example="0123456789"),
     *                 @OA\Property(property="address", type="string", example="123 Đường ABC, TP.HCM"),
     *                @OA\Property(property="payment_method", type="string", example="cash"),
     *                 @OA\Property(property="products[0][product_id]", type="integer", example=3),
     *                 @OA\Property(property="products[0][quantity]", type="integer", example=2),
     *                 
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đơn hàng được tạo thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Tạo đơn hàng thành công"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Lỗi dữ liệu đầu vào"
     *     )
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'payment_method' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);
    
        $total_price = 0;
        $order_items = [];
    
        foreach ($request->products as $product) {
            $productModel = Product::find($product['product_id']);
            if (!$productModel) continue;
            if ($product['quantity'] > $productModel->stock) {
                return response()->json([
                    'status' => 400,
                    'message' => "Sản phẩm '{$productModel->name}' chỉ còn {$productModel->stock} sản phẩm trong kho",
                    'errors' => [
                        'product_id' => $productModel->id,
                        'available_stock' => $productModel->stock,
                    ]
                ], 400);
            }
            $original_price = $productModel->price;
    
            $discount_price = $original_price;
            $product_discount = ProductDiscount::where('product_id', $productModel->id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
            if ($product_discount) {
                $discount_price = $original_price * (1 - ($product_discount->percentage / 100));
            }
    
            $item_total_price = $discount_price * $product['quantity'];
            $total_price += $item_total_price;
    
            $order_items[] = [
                'product_id' => $productModel->id,
                'quantity' => $product['quantity'],
                'price' => $original_price,
                'final_price' => $discount_price,
            ];
        }
    
        $discountAmount = 0;
        if ($request->discount_id) {
            $discount = Discount::find($request->discount_id);
            if ($discount) {
                if ($discount->type === 'percentage') {
                    $discountAmount = ($total_price * $discount->value) / 100;
                } elseif ($discount->type === 'fixed') {
                    $discountAmount = $discount->value;
                }
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
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'final_price' => $item['final_price'],
            ]);
    
            $productToUpdate = Product::find($item['product_id']);
            if ($productToUpdate) {
                $productToUpdate->stock -= $item['quantity'];
                $productToUpdate->save();
            }
        }
    
        return response()->json([
            'status' => 200,
            'message' => 'Tạo đơn hàng thành công',
            'data' => new OrderResource($order),
        ], 200);
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
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(@OA\Property(property="status", type="string", example="completed"))
     *     ),
     *     @OA\Response(response=200, description="Cập nhật thành công")
     * )
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);
        $order = Order::find($id);
        if (!$order) return response()->json(['status' => 404, 'message' => 'Không tìm thấy đơn hàng'], 404);

        $order->update(['status' => $request->status]);
        return response()->json(['status' => 200, 'message' => 'Cập nhật thành công'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
