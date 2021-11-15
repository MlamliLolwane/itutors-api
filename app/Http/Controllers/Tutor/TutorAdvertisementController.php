<?php

namespace App\Http\Controllers\Tutor;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TutorAdvertisement;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;

class TutorAdvertisementController extends Controller
{
    use StandardizedResponse;

    /**
     * List of all the tutor's advertisements
     */
    public function list(Request $request)
    {
        try {
            $tutor_advertisements = TutorAdvertisement::all()->where(['id' => $request['id']]);

            return $this->successResponse($tutor_advertisements, Response::HTTP_OK);
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
            'title' => 'required|string',
            'content' => 'required|string',
            'price' => 'required|string',
            'max_participants' => 'required|integer',
            'duration' => 'required|string',
            'ad_type' => 'required|string',
            'tutor_id' => 'required|integer',
            'subject_id' => 'required|string',
        ]);

        $tutor_advertisement = TutorAdvertisement::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'price' => $request['price'],
            'max_participants' => $request['max_participants'],
            'duration' => $request['duration'],
            'ad_type' => $request['ad_type'],
            'tutor_id' => $request['tutor_id'],
            'subject_id' => $request['subject_id']
        ]);

        return $this->successResponse($tutor_advertisement, Response::HTTP_CREATED);
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
            $tutor_advertisement = TutorAdvertisement::find($id);

            return $this->successResponse($tutor_advertisement, Response::HTTP_OK);
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
        $tutor_advertisement = TutorAdvertisement::find($request["id"]);

        $tutor_advertisement->fill($request->all());

        if ($tutor_advertisement->isClean()) {
            return $this->failureResponse('No changes made because no value was supplied', Response::HTTP_NOT_MODIFIED);
        }

        try {
            $tutor_advertisement->save();

            return $this->successResponse($tutor_advertisement, Response::HTTP_OK);
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
        $tutor_advertisement = TutorAdvertisement::find($request['id']);

        $tutor_advertisement->delete();

        return $this->successResponse($tutor_advertisement, Response::HTTP_OK);
    }
}
