<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Employee::with('division')->paginate(10);

        return new EmployeeCollection($divisions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('employee', 'public');
        }

        $employee = Employee::create($validated);

        return response()->json([
            'status' => 'status',
            'message' => 'Employee created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load('division');

        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }
            $validated['image'] = $request->file('image')->store('employee', 'public');
        }

        $employee->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if (Storage::disk('public')->exists($employee->image)) {
            Storage::disk('public')->delete($employee->image);
        }

        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully',
        ]);
    }
}
