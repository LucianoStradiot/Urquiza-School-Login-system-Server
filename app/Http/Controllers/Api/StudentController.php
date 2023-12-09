<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StudentResource::collection(Student::query()->orderBy("id", "desc")->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $student = Student::create($data);
        return response()->json(new StudentResource($student), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);
        try {
            $student->delete();
            return response()->json(['message' => 'Student deleted successfully'], 204);
        } catch (\Exception $e) {
            \Log::error('Error deleting student: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting student'], 500);
        }
    }
}
