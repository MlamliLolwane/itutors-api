<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StudentProfile;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;

class StudentProfileController extends Controller
{
    use StandardizedResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer|unique:student_profiles',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'study_level' => 'required|string',
            'description' => 'required|string',
        ]);

        $student_profile = StudentProfile::create([
            'student_id' => $request['student_id'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'study_level' => $request['study_level'],
            'description' => $request['description'],
            'file_name' => $request['file_name'],
            'file_path' => $request['file_path']
        ]);

        return $this->successResponse($student_profile, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $student_profile = StudentProfile::find($request["student_id"]);

            return $this->successResponse($student_profile, Response::HTTP_OK);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentProfile $student)
    {
        $student_profile = StudentProfile::where('student_id', $request["student_id"])->first();

        $student_profile->fill($request->all());

        if ($student_profile->isClean()) {
            return $this->failureResponse('No changes made because no value was supplied', Response::HTTP_NOT_MODIFIED);
        }

        try {
            $student_profile->save();

            return $this->successResponse($student_profile, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->failureResponse(
                "An error occured and your request couldn't be processed",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $profile = StudentProfile::find($request['student_id']);
        
        $profile->delete();

        
        return $this->successResponse($profile, Response::HTTP_OK);
    }
}
