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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {

            return StudentResource::collection(Student::query()->orderBy("id", "desc")->paginate(10));
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
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
        try {


            return new StudentResource($student);
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json("", 204);
    }
}
