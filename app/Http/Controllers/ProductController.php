<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Color;
use App\Models\EmployeeProduct;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Flower Store API",
 *      description="API documentation for Flower Store",
 * )
 *
 *
 * 

 * @OA\Post(
     *     path="/api/products",
     *     summary="Thêm sản phẩm mới",
     *     description="API để thêm sản phẩm mới với thông tin chi tiết và upload ảnh",
     *     tags={"Products"},
     *     security={ {"bearerAuth":{}} }, 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "description", "price", "category_id", "image"},
     *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
     *                 @OA\Property(property="description", type="string", example="Hoa hồng đỏ đẹp"),
     *                 @OA\Property(property="price", type="number", format="float", example=150000),
     *                @OA\Property(property="stock", type="number", format="integer", example=100),
     *                 @OA\Property(property="category_id", type="integer", example=1),
     *                @OA\Property(property="employee_id", type="integer", example=1),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sản phẩm được tạo thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Product created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
     *                 @OA\Property(property="description", type="string", example="Hoa hồng đỏ đẹp"),
     *                 @OA\Property(property="price", type="number", format="float", example=150000),
     *                @OA\Property(property="stock", type="number", format="integer", example=100),
     *                 @OA\Property(property="category_id", type="integer", example=1),
     *                 @OA\Property(property="image_url", type="string", example="assets/images/hoahong.jpg"),
     *             ),
     *         ),
     *     ),
     *  
     * )
    * 
 */


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
    *    @OA\Get(
    *     path="/api/products",
    *     summary="Lấy danh sách hoa",
    *   tags={"Products"},
    *     @OA\Response(response=200, description="Danh sách hoa"),
    * )
    * 
    */
    public function index()
    {
        $products = Product::with('ingredients')->get();
        
        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách sản phẩm thành công',
            'data' => ProductResource::collection($products),
           
        ],200);
    }
        /**
     * @OA\Get(
     *     path="/api/discount-product",
     *     operationId="getAllProductDiscount",
     *     tags={"Products"},
     *     summary="Lấy danh sách sản phẩm giảm giá",
     *     description="Trả về danh sách tất cả sản phẩm có giá cuối (final_price) nhỏ hơn giá gốc (price).",
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách sản phẩm giảm giá thành công",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Lấy danh sách sản phẩm giảm giá thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProductResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi server",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="Đã xảy ra lỗi khi lấy danh sách sản phẩm")
     *         )
     *     )
     * )
     */
    public function getallproductdiscount()
    {
        $products = Product::all();
        $discountedProducts = $products->filter(function ($product) {
            return $product->final_price < $product->price;
        });

        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách sản phẩm giảm giá thành công',
            'data' => ProductResource::collection($discountedProducts)
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/products/get8products",
     *     summary="Lấy danh sách 8 sản phẩm đầu tiên",
     *     description="Trả về danh sách 8 sản phẩm đầu tiên trong cửa hàng",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách hoa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Lấy danh sách sản phẩm thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Hoa hướng dương"),
     *                     @OA\Property(property="description", type="string", example="Hoa tươi tặng sinh nhật"),
     *                     @OA\Property(property="price", type="number", format="float", example=120000),
     *                     @OA\Property(property="category_id", type="integer", example=3),
     *                     @OA\Property(property="image_url", type="string", example="https://example.com/images/sunflower.jpg"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-11T09:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-11T09:30:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function get8product()
    {
        $products = Product::take(8)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách sản phẩm thành công',
            'data' => ProductResource::collection($products),
        ], 200);
    }





    public function getOptions($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Sản phẩm không tồn tại'
            ], 404);
        }
        $sizes = Size::select('id', 'name', 'price_modifier')->get();
        $colors = Color::select('id', 'name')->get();

        return response()->json([
            'status' => 200,
            'data' => [
                'sizes' => $sizes,
                'colors' => $colors
            ]
        ]);
    }


    public function searchProducts(Request $request)
    {
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng cung cấp từ khóa tìm kiếm',
                'data' => []
            ], 400);
        }

        $products = Product::where('name', 'like', '%' . $query . '%')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Tìm kiếm sản phẩm thành công',
            'data' => ProductResource::collection($products)
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'employee_id' => 'required|nullable|exists:employees,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('assets/images'), $imageName); 
            $validatedData['image_url'] = 'assets/images/' . $imageName; 
        }
    
        $product = Product::create($validatedData);
        EmployeeProduct::create([
            'employee_id' => $request->employee_id,
            'product_id' => $product->id,
            'action' => 'create'
        ]);
        return response()->json([
            'status' => 201,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */


/**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     summary="Lấy thông tin chi tiết sản phẩm",
 *     description="Trả về thông tin chi tiết của một sản phẩm",
 *     operationId="getProductById",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của sản phẩm",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lấy thông tin sản phẩm thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Lấy thông tin sản phẩm thành công"),
 *             @OA\Property(property="data", ref="#/components/schemas/ProductResource")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy sản phẩm",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Product not found"),
 *             @OA\Property(property="errors", type="string", nullable=true)
 *         )
 *     )
 * )
 */
    public function show($id)
    {
     $product = Product::with('ingredients')->find($id);
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',

            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Lấy thông tin sản phẩm thành công',
            'data' => new ProductResource($product),
        ], 200);
    }


/**
 * @OA\Get(
 *     path="/api/products/category/{category_id}",
 *     summary="Lấy thông tin chi tiết hoa theo danh mục",
 *     description="Trả về danh sách các sản phẩm hoa theo ID danh mục",
 *     operationId="getFlowersByCategoryId",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="category_id",
 *         in="path",
 *         required=true,
 *         description="ID của danh mục hoa",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lấy thông tin hoa thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Lấy thông tin hoa thành công"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Hoa hồng đỏ"),
 *                     @OA\Property(property="description", type="string", example="Bó hoa tình yêu lãng mạn"),
 *                     @OA\Property(property="price", type="number", format="float", example=150000),
 *                     @OA\Property(property="category_id", type="integer", example=2),
 *                     @OA\Property(property="image_url", type="string", example="https://example.com/images/rose.jpg"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-11T10:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-11T10:05:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy hoa trong danh mục này",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="No flowers found in this category"),
 *             @OA\Property(property="errors", type="string", nullable=true)
 *         )
 *     )
 * )
 */

public function showByCategory($category_id)
{
    $product = product::where('category_id', $category_id)->get();

    if ($product->isEmpty()) {
        return response()->json([
            'status' => 404,
            'message' => 'No flowers found in this category',
        ], 404);
    }

    return response()->json([
        'status' => 200,
        'message' => 'Lấy thông tin hoa thành công',
        'data' => ProductResource::collection($product),
    ], 200);
}
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

/**
 * @OA\Post(
 *     path="/api/products/{id}",
 *     summary="Cập nhật sản phẩm",
 *     description="API cập nhật sản phẩm, hỗ trợ upload ảnh",
 *     tags={"Products"},
 *     security={ {"bearerAuth":{}} },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của sản phẩm cần cập nhật",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
 *                 @OA\Property(property="description", type="string", example="Hoa hồng đỏ đẹp"),
 *                 @OA\Property(property="price", type="number", format="float", example=150000),
 *                @OA\Property(property="stock", type="number", format="integer", example=100),
 *                 @OA\Property(property="category_id", type="integer", example=1),
 *                @OA\Property(property="employee_id", type="integer", example=1),
 *                 @OA\Property(property="image", type="string", format="binary", description="Ảnh sản phẩm (nếu có)"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sản phẩm cập nhật thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Product updated successfully"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
 *                 @OA\Property(property="description", type="string", example="Hoa hồng đỏ đẹp"),
 *                 @OA\Property(property="price", type="number", format="float", example=150000),
 *               @OA\Property(property="stock", type="number", format="integer", example=100),
 *                 @OA\Property(property="category_id", type="integer", example=1),
 *                 @OA\Property(property="image_url", type="string", example="assets/images/hoahong.jpg"),
 *             )
 *         )
 *     )
 * )
 */


     

 public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'status' => 404,
            'message' => 'Product not found',
        ], 404);
    }

    $validatedData = $request->validate([
        'name' => 'sometimes|required|max:255',
        'description' => 'sometimes|required',
        'price' => 'sometimes|required|numeric',
        'stock' => 'sometimes|required|numeric',
        'category_id' => 'sometimes|required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images'), $imageName);
        $validatedData['image_url'] = 'assets/images/' . $imageName;
    }

    EmployeeProduct::create([
        'employee_id' => $request->employee_id,
        'product_id' => $product->id,
        'action' => 'update'
    ]);
    $product->update($validatedData);

    return response()->json([
        'status' => 200,
        'message' => 'Product updated successfully',
        'data' => new ProductResource($product),
    ], 200);
}



 
    /**
     * Remove the specified resource from storage.
     */

     /**
 * @OA\Delete(
 *     path="/api/products/{id}",
 *     summary="Xóa sản phẩm",
 *     description="API để xóa một sản phẩm khỏi hệ thống.",
 *     tags={"Products"},
 *    security={ {"bearerAuth":{}} },
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
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'status' => 404,
            'message' => 'Không tìm thấy sản phẩm',
        ], 404);
    }

    $product->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Xóa sản phẩm thành công',
    ], 200);
}
}
