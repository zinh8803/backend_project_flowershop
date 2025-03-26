<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;




class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

       /**
    *    @OA\Get(
    *     path="/api/categories",
    *     summary="Lấy danh sách danh mục hoa",
    *   tags={"categories"},
    *     @OA\Response(response=200, description="Danh sách danh mục hoa"),
    * )
    * 
    */

    
    public function index()
    {
        $categories = Category::all();
      return response()->json(
        [
         'status' => 200,
            'message' => 'lấy danh sách danh mục thành công',
            'data' => CategoryResource::collection($categories)
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
     *     path="/api/categories",
     *     summary="Thêm danh mục mới",
     *    
     *     tags={"categories"},
     *     security={ {"bearerAuth":{}} }, 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "image"},
     *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
     * 
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
      */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('assets/categories_image'), $imageName); 
            $validatedData['image_url'] = 'assets/categories_image/' . $imageName; 
        }
        $category = Category::create($validatedData);

        return response()->json([
            'status' => 201,
            'message' => 'Category created',
            'data' => new CategoryResource($category)

        ],201);
    }

    /**
     * Display the specified resource.
     */
/**
 * @OA\Get(
 *     path="/api/categories/{id}",
 *     summary="Lấy thông tin chi tiết danh mục",
 *     description="Trả về thông tin chi tiết của một danh mục",
 *    
 *     tags={"categories"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của danh mục",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lấy thông tin danh mục thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Lấy thông tin danh mục thành công"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Hoa tươi"),
 *                 @OA\Property(property="description", type="string", example="Chuyên các loại hoa tươi nhập khẩu"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-07T14:30:00Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-07T14:30:00Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy danh mục",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Category not found"),
 *             @OA\Property(property="errors", type="string", nullable=true)
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found'
            ], 404);
        }
        return response()->json(
        [
            'status' => 200,
                'message' => 'lấy danh mục thành công',
                'data' => new CategoryResource($category)
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

/**
 * @OA\Post(
 *     path="/api/categories/{id}",
 *     summary="Cập nhật sản phẩm",
 *     description="API cập nhật sản phẩm, hỗ trợ upload ảnh",
 *     tags={"categories"},
 *    security={ {"bearerAuth":{}} },
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
 *               
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
 *                
 *                 @OA\Property(property="image_url", type="string", example="assets/images/hoahong.jpg"),
 *             )
 *         )
 *     )
 * )
 */

 public function update(Request $request, $id)
 {
     $category = Category::find($id);
 
     // Kiểm tra nếu không tìm thấy category
     if (!$category) {
         return response()->json([
             'status' => 404,
             'message' => 'Category not found',
         ], 404);
     }
 
     $validatedData = $request->validate([
         'name' => 'required|unique:categories,name,' . $id . '|max:255',
         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);
 
     if ($request->hasFile('image')) {
         $image = $request->file('image');
         $imageName = time() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('assets/categories_image'), $imageName);
         $validatedData['image_url'] = 'assets/categories_image/' . $imageName;
     }
 
     $category->update($validatedData);
 
     return response()->json([
         'status' => 200,
         'message' => 'Category updated successfully',
         'data' => new CategoryResource($category),
     ], 200);
 }
 
    /**
     * Remove the specified resource from storage.
     */
      /**
 * @OA\Delete(
 *     path="/api/categories/{id}",
 *     summary="Xóa sản phẩm",
 *     description="API để xóa một sản phẩm khỏi hệ thống.",
 *     tags={"categories"},
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
 *            
 *         )
 *     )
 * )
 */
public function destroy($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json([
            'status' => 404,
            'message' => 'Category not found',
        ], 404);
    }

    $category->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Category deleted',
    ], 200);
}
}
