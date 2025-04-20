<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    /**
    *    @OA\Get(
    *     path="/api/schedules",
    *     summary="Lấy danh sách lịch trình",
    *   tags={"schedules"},
    *     @OA\Response(response=200, description="Danh sách lịch trình"),
    * )
    * 
    */
    public function index()
    {
        $schedules = Schedule::all();
        $groupedSchedules = $schedules->groupBy('employee_id');
        return response()->json([
            'status' => 200,
            'message' => 'Schedules retrieved successfully',
            'data' => $groupedSchedules->map(function ($schedules) {
                return [
                    'employee_id' => $schedules->first()->employee_id, 
                    'schedules' => ScheduleResource::collection($schedules)
                ];
            })->values(), 
        ], 200);
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
 *     path="/api/schedules",
 *     summary="Tạo lịch trình mới",
 *     tags={"schedules"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="start_date", type="string", format="date", example="2025-04-01"),
 *             @OA\Property(property="end_date", type="string", format="date", example="2025-04-30"),
 *             @OA\Property(property="day_of_week", type="array", @OA\Items(type="integer"), example={1,3,5}),
 *             @OA\Property(property="shift", type="object", example={"1": "morning", "3": "afternoon", "5": "full_day"}),
 *             @OA\Property(property="employee_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Lịch trình được tạo thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Schedules created successfully"),
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="start_date", type="string", format="date", example="2025-04-01"),
 *                 @OA\Property(property="end_date", type="string", format="date", example="2025-04-01"),
 *                 @OA\Property(property="day_of_week", type="integer", example=1),
 *                 @OA\Property(property="shift", type="string", example="morning"),
 *                 @OA\Property(property="employee_id", type="integer", example=10)
 *             ))
 *         )
 *     )
 * )
 */


    public function store(Request $request)
    {
    $request->validate([
        'employee_id' => 'required|integer|exists:employees,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'day_of_week' => 'required|array',
        'day_of_week.*' => 'integer|in:0,1,2,3,4,5,6', 
        'shift' => 'required|array',
        'shift.*' => 'in:morning,afternoon,full_day', 
    ]);

    $schedules = [];
    $start_date = Carbon::parse($request->start_date);
    $end_date = Carbon::parse($request->end_date);
    $selected_days = $request->day_of_week;  
    $shifts = $request->shift;  
    for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
        if (in_array($date->dayOfWeek, $selected_days)) {
            $shift_for_day = $shifts[$date->dayOfWeek]; 
            $schedules[] = Schedule::create([
                'employee_id' => $request->employee_id,
                'start_date' => $date->toDateString(),
                'end_date' => $date->toDateString(),
                'day_of_week' => $date->dayOfWeek,
                'shift' => $shift_for_day,
            ]);
        }
    }
    return response()->json([
        'status' => 'success',
        'message' => 'Schedules created successfully',
        'data' => ScheduleResource::collection($schedules),
    ], 201);
    }

    /**
 * @OA\Get(
 *     path="/api/employees/schedules/{employee_id}",
 *     summary="Tìm lịch trình của nhân viên dựa trên employee_id",
 *     tags={"schedules"},
 *     @OA\Parameter(
 *         name="employee_id",
 *         in="path",
 *         description="ID của nhân viên",
 *         required=true,
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lịch trình của nhân viên được lấy thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Schedules retrieved successfully"),
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="start_date", type="string", format="date", example="2025-04-01"),
 *                 @OA\Property(property="end_date", type="string", format="date", example="2025-04-01"),
 *                 @OA\Property(property="day_of_week", type="integer", example=1),
 *                 @OA\Property(property="shift", type="string", example="morning"),
 *                 @OA\Property(property="employee_id", type="integer", example=10)
 *             ))
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy lịch trình cho nhân viên này",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="No schedules found for this employee")
 *         )
 *     )
 * )
 */


    public function show($employee_id)
    {
     $schedules = Schedule::where('employee_id', $employee_id)->get();

     if ($schedules->isEmpty()) {
         return response()->json([
             'status' => 404,
             'message' => 'No schedules found for this employee',
         ], 404);
     }

     return response()->json([
         'status' => 200,
         'message' => 'Schedules retrieved successfully',
         'data' => ScheduleResource::collection($schedules), 
     ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
 * @OA\post(
 *     path="/api/schedules/{id}",
 *     summary="Cập nhật lịch trình của nhân viên",
 *     tags={"schedules"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID của lịch trình cần cập nhật",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="start_date", type="string", format="date", example="2025-04-01"),
 *             @OA\Property(property="shift", type="string", example="afternoon"),
 *             @OA\Property(property="employee_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lịch trình đã được cập nhật thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Schedule updated successfully"),
 *             @OA\Property(property="data", type="object", 
 *                 @OA\Property(property="id", type="integer", example=1),

 *                 @OA\Property(property="day_of_week", type="integer", example=3),
 *                 @OA\Property(property="shift", type="string", example="afternoon"),
 *                 @OA\Property(property="employee_id", type="integer", example=10)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy lịch trình với ID này",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Schedule not found")
 *         )
 *     )
 * )
 */

 public function update(Request $request, $id)
{
    $schedule = Schedule::find($id);

    if (!$schedule) {
        return response()->json([
            'status' => 'error',
            'message' => 'Schedule not found',
        ], 404);
    }

    $request->validate([
        'start_date' => 'required|date',
        'shift' => 'required|in:morning,afternoon,full_day',
        'employee_id' => 'required|integer|exists:employees,id',
    ]);

    $startDate = Carbon::parse($request->start_date);
    $dayOfWeek = $startDate->dayOfWeek; 

    $schedule->start_date = $startDate->format('Y-m-d');
    $schedule->end_date = $startDate->format('Y-m-d');
    $schedule->day_of_week = $dayOfWeek;
    $schedule->shift = $request->shift;
    $schedule->employee_id = $request->employee_id;
    $schedule->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Schedule updated successfully',
        'data' => new ScheduleResource($schedule),
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    /**
 * @OA\Delete(
 *     path="/api/schedules/{id}",
 *     summary="Xóa lịch trình của nhân viên dựa trên id",
 *     tags={"schedules"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID của lịch trình cần xóa",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lịch trình đã được xóa thành công",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Schedule deleted successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Không tìm thấy lịch trình với ID này",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Schedule not found")
 *         )
 *     )
 * )
 */

    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        if(!$schedule)
        {
            return response()->json([
                'status' => 404,
                'message' => 'Schedule not found',
            ], 404);
        }
        $schedule->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Schedule deleted successfully',
        ], 200);
    }
}
