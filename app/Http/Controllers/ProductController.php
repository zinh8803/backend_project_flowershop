<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Flower Store API",
 *      description="API documentation for Flower Store",
 * )
 *
 * @OA\Get(
 *     path="/api/products",
 *     summary="Lấy danh sách hoa",
 *     @OA\Response(response=200, description="Danh sách hoa"),
 * )
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
    public function index()
    {
        $products = Product::all();
        
        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách sản phẩm thành công',
            'data' => ProductResource::collection($products),
            'errors' => null
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
            'errors' => null,
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
 * @OA\Put(
 *     path="/api/products/{id}",
 *     summary="Cập nhật sản phẩm",
 *     description="API để cập nhật thông tin sản phẩm và thay đổi ảnh nếu có",
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
 *                 required={"name", "description", "price", "category_id"},
 *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
 *                 @OA\Property(property="description", type="string", example="Hoa hồng đỏ đẹp"),
 *                 @OA\Property(property="price", type="number", format="float", example=150000),
 *                 @OA\Property(property="category_id", type="integer", example=1),
 *                 @OA\Property(property="image", type="string", format="binary", description="Hình ảnh sản phẩm mới (không bắt buộc)"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sản phẩm được cập nhật thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Cập nhật sản phẩm thành công"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
 *                 @OA\Property(property="description", type="string", example="Hoa hồng đỏ đẹp"),
 *                 @OA\Property(property="price", type="number", format="float", example=150000),
 *                 @OA\Property(property="category_id", type="integer", example=1),
 *                 @OA\Property(property="image_url", type="string", example="assets/images/hoahong.jpg"),
 *             ),
 *             @OA\Property(property="errors", type="object", nullable=true),
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Dữ liệu không hợp lệ",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="message", type="string", example="Dữ liệu không hợp lệ"),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="name", type="array",
 *                     @OA\Items(type="string", example="Tên sản phẩm đã tồn tại")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy sản phẩm",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Không tìm thấy sản phẩm")
 *         )
 *     )
 * )
 */



     
 public function update(Request $request, Product $product)
 {
     $validator = Validator::make($request->all(), [
         'name' => 'required|max:255|unique:products,name,' . $product->id,
         'description' => 'required',
         'price' => 'required|numeric',
         'category_id' => 'required|exists:categories,id',
         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);
 
     // Nếu có lỗi validation, trả về format chuẩn
     if ($validator->fails()) {
         return response()->json([
             'status' => 422,
             'message' => 'Dữ liệu không hợp lệ',
             'data' => null,
             'errors' => $validator->errors(),
         ], 422);
     }
 
     $validatedData = $validator->validated();
 
     // Nếu có ảnh mới thì cập nhật
     if ($request->hasFile('image')) {
         // Xóa ảnh cũ nếu tồn tại
         if ($product->image_url && file_exists(public_path($product->image_url))) {
             unlink(public_path($product->image_url));
         }
 
         // Upload ảnh mới
         $image = $request->file('image');
         $imageName = time() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('assets/images'), $imageName);
         $validatedData['image_url'] = 'assets/images/' . $imageName;
     }
 
     $product->update($validatedData);
 
     return response()->json([
         'status' => 200,
         'message' => 'Cập nhật sản phẩm thành công',
         'data' => new ProductResource($product),
         'errors' => null,
     ], 200);
 }
 
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
