<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Resources\InvoiceResource;

class InvoiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/invoices",
     *     summary="Lấy danh sách hóa đơn",
     *     tags={"invoices"},
     *     @OA\Response(response=200, description="Danh sách hóa đơn")
     * )
     */
    public function index()
    {
        $invoices = Invoice::all();
        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách hóa đơn thành công',
            'data' => InvoiceResource::collection($invoices),
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/invoices",
     *     summary="Thêm hóa đơn",
     *     tags={"invoices"},
     *     security={ {"bearerAuth":{}} },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"order_id", "total", "employee_id"},
     *                 @OA\Property(property="order_id", type="integer", example=1),
     *                 @OA\Property(property="total", type="number", format="float", example=500000),
     *                @OA\Property(property="discount_id", type="integer", example=1),
     *                @OA\Property(property="employee_id", type="integer", example=1),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Hóa đơn được tạo thành công")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'total' => 'required|numeric',
            'discount_id' => 'nullable|integer',
            'order_id' => 'nullable|integer',
            'employee_id' => 'nullable|integer',
        ]);

        $invoice = Invoice::create($validatedData);

        return response()->json([
            'status' => 201,
            'message' => 'Hóa đơn được tạo thành công',
            'data' => new InvoiceResource($invoice),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/invoices/{id}",
     *     summary="Cập nhật hóa đơn",
     *     tags={"invoices"},
     *     security={ {"bearerAuth":{}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của hóa đơn",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "email", "phone_number", "address", "total", "status"},
     *                 @OA\Property(property="name", type="string", example="Nguyễn Văn B"),
     *                 @OA\Property(property="email", type="string", example="updated@example.com"),
     *                 @OA\Property(property="phone_number", type="string", example="0912345678"),
     *                 @OA\Property(property="address", type="string", example="456 Đường XYZ, TP.HCM"),
     *                 @OA\Property(property="total", type="number", format="float", example=600000),
     *                 @OA\Property(property="status", type="string", example="completed")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Cập nhật hóa đơn thành công"),
     *     @OA\Response(response=404, description="Không tìm thấy hóa đơn")
     * )
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'status' => 404,
                'message' => 'Hóa đơn không tồn tại',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'total' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $invoice->update($validatedData);

        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật hóa đơn thành công',
            'data' => new InvoiceResource($invoice),
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/invoices/{id}",
     *     summary="Xóa hóa đơn",
     *     tags={"invoices"},
     *     security={ {"bearerAuth":{}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của hóa đơn cần xóa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Xóa hóa đơn thành công"),
     *     @OA\Response(response=404, description="Không tìm thấy hóa đơn")
     * )
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'status' => 404,
                'message' => 'Hóa đơn không tồn tại',
            ], 404);
        }

        $invoice->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Xóa hóa đơn thành công',
        ], 200);
    }
}
