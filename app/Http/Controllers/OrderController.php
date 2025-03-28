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
     *                 @OA\Property(property="products[1][product_id]", type="integer", example=5),
     *                 @OA\Property(property="products[1][quantity]", type="integer", example=1)
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
