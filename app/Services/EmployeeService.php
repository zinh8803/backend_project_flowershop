<?php

namespace App\Services;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    public function getAllEmployees()
    {
        $employeeProducts = Employee::all();
        return EmployeeResource::collection($employeeProducts);
    }

    public function createEmployee($data)
    {
        $data['password'] = Hash::make($data['password']);
        $employeeProduct = Employee::create($data);
        return new EmployeeResource($employeeProduct);
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }

    public function updateEmployee($id, $data)
    {
        $employeeProduct = Employee::findOrFail($id);
        $employeeProduct->update($data);
        return $employeeProduct;
    }

    public function deleteEmployee($id)
    {
        $employeeProduct = Employee::findOrFail($id);
        $employeeProduct->delete();
        return true;
    }
}

