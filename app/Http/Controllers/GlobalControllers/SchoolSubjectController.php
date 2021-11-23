<?php

namespace App\Http\Controllers\GlobalControllers;

use Illuminate\Http\Request;
use App\Models\SchoolSubject;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;

class SchoolSubjectController extends Controller
{
    use StandardizedResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $school_subjects = SchoolSubject::all();

            return $this->successResponse($school_subjects, Response::HTTP_OK);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string',
            'grade' => 'required|integer'
        ]);

        try {
            $school_subject = SchoolSubject::create([
                'subject_name' => $request['subject_name'],
                'grade' => $request['grade']
            ]);

            return $this->successResponse($school_subject, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $school_subject = SchoolSubject::find($request["id"]);

            $school_subject->fill($request->all());

            if ($school_subject->isClean()) {
                return $this->failureResponse('No changes made because no value was supplied', Response::HTTP_NOT_MODIFIED);
            }

            $school_subject->save();

            return $this->successResponse($school_subject, Response::HTTP_OK);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $school_subject = SchoolSubject::find($request['id']);

        $school_subject->delete();

        return $this->successResponse("School subject deleted successfully", Response::HTTP_OK);
    }
}
