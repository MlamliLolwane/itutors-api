<?php

namespace App\Http\Controllers\Tutor;

use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;

class TutorProfileController extends Controller
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
            'tutor_id' => 'required|integer|unique:tutor_profiles',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'job_title' => 'required|string',
            'description' => 'required|string',
        ]);

        $tutor_profile = TutorProfile::create([
            'tutor_id' => $request['tutor_id'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'job_title' => $request['job_title'],
            'description' => $request['description'],
            'file_name' => $request['file_name'],
            'file_path' => $request['file_path']
        ]);

        return $this->successResponse($tutor_profile, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $profile = TutorProfile::find($id);

            return $this->successResponse($profile, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->failureResponse($th, Response::HTTP_INTERNAL_SERVER_ERROR);
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
        $tutor_profile = TutorProfile::where('tutor_id', $request["tutor_id"])->first();

        $tutor_profile->fill($request->all());

        if ($tutor_profile->isClean()) {
            return $this->failureResponse('No changes made because no value was supplied', Response::HTTP_NOT_MODIFIED);
        }

        try {
            $tutor_profile->save();

            return $this->successResponse($tutor_profile, Response::HTTP_OK);
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
        $profile = TutorProfile::find($request['tutor_id']);

        $profile->delete();

        //dd($profile);
        return $this->successResponse($profile, Response::HTTP_OK);
    }
}
