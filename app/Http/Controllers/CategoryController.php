<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\EmployeeCategory;
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
 *     tags={"categories"},
 *     security={ {"bearerAuth":{}} }, 
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"name", "image"},
 *                 @OA\Property(property="employee_id", type="integer", nullable=true, example=1),
 *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
 *                 @OA\Property(property="image", type="string", format="binary")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Danh mục được tạo thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=201),
 *             @OA\Property(property="message", type="string", example="Category created"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
 *                 @OA\Property(property="image_url", type="string", example="assets/categories_image/hoahong.jpg"),
 *                 @OA\Property(property="employee_id", type="integer", nullable=true, example=1)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Lỗi xác thực dữ liệu đầu vào"
 *     )
 * )
 */

    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'employee_id' => 'nullable|integer',
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
        EmployeeCategory::create([
            'employee_id' => $request->employee_id,
            'category_id' => $category->id,
            'action' => 'add'
        ]);
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
 *     summary="Cập nhật danh mục",
 *     description="API cập nhật danh mục",
 *     tags={"categories"},
 *    security={ {"bearerAuth":{}} },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của danh mục cần cập nhật",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="Hoa Hồng"),
 *                 @OA\Property(property="employee_id", type="integer", nullable=true, example=1),
 *                 @OA\Property(property="image", type="string", format="binary", description="Ảnh danh mục"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="danh mục cập nhật thành công",
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
     if (!$category) {
         return response()->json([
             'status' => 404,
             'message' => 'Category not found',
         ], 404);
     }
 
     $validatedData = $request->validate([
         'name' => 'required|unique:categories,name,' . $id . '|max:255',
         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         'employee_id' => 'nullable|integer',
     ]);
 
     if ($request->hasFile('image')) {
         $image = $request->file('image');
         $imageName = time() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('assets/categories_image'), $imageName);
         $validatedData['image_url'] = 'assets/categories_image/' . $imageName;
     }
 
     $category->update($validatedData);
     EmployeeCategory::create([
         'employee_id' => $request->employee_id,
         'category_id' => $category->id,
         'action' => 'update'
     ]);
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
 *     summary="Xóa danh mục",
 *     description="API để xóa một danh mục khỏi hệ thống.",
 *     tags={"categories"},
 *    security={ {"bearerAuth":{}} },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID của danh mục cần xóa",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Xóa danh mục thành công",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Xóa danh mục thành công"),
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
