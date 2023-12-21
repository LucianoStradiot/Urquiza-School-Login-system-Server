<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Mail\StudentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {
            $students = Student::where('approved', false)->orderBy("id", "desc")->get();

            return StudentResource::collection($students);
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

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

    public function updateApprovalStatus(Request $request, Student $id)
    {
        try {
            $approved = $request->input('approved', false);

            $id->approved = $approved;
            $id->save();

            Mail::to($id->email)->send(new StudentMail($approved));

            return response()->json(['message' => 'Estado de aprobación actualizado con éxito.']);
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function destroy(Request $request, Student $id)
    {
        try {
            $approved = $request->input('approved', false);

            $id->approved = $approved;
            $id->delete();

            Mail::to($id->email)->send(new StudentMail($approved));

            return response()->json(['message' => 'Estado de aprobación actualizado con éxito.']);
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
