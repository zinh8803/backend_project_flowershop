<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "description", "price", "category_id", "image"},
     *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
     *                 @OA\Property(property="description", type="string", example="Hoa hồng đỏ đẹp"),
     *                 @OA\Property(property="price", type="number", format="float", example=150000),
     *                 @OA\Property(property="category_id", type="integer", example=1),
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
        $products = Product::all();
        
        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách sản phẩm thành công',
            'data' => ProductResource::collection($products),
           
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('assets/images'), $imageName); 
            $validatedData['image_url'] = 'assets/images/' . $imageName; 
        }
    
        $product = Product::create($validatedData);
    
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
    $product = Product::find($id);

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
 *                 @OA\Property(property="category_id", type="integer", example=1),
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
        'category_id' => 'sometimes|required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images'), $imageName);
        $validatedData['image_url'] = 'assets/images/' . $imageName;
    }

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
