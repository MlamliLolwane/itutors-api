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
    public function list($tutor_id)
    {
        try {
            //Should also get deleted advertisements to show the tutor analytics of those advertisements too
            $tutor_advertisements = TutorAdvertisement::where(['tutor_id' => $tutor_id])->get();

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
            'price' => 'required|integer',
            'max_participants' => 'required|integer',
            'duration' => 'required|integer',
            'tutor_id' => 'required|integer',
            'subject_id' => 'required|string',
        ]);

        $tutor_advertisement = TutorAdvertisement::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'price' => $request['price'],
            'max_participants' => $request['max_participants'],
            'duration' => $request['duration'],
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
    public function show(Request $request)
    {
        try {
            $tutor_advertisement = TutorAdvertisement::find($request['id']);

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
    /**
     * Update advertisement is not really recommended because we can just take the data from the 
     * frontend to create a new advertisement. Also updating the tutor's advertisement directly
     * will mess up the integrity of the data.
     */

    // public function update(Request $request)
    // {
    //     $tutor_advertisement = TutorAdvertisement::find($request["id"]);

    //     $tutor_advertisement->fill($request->all());

    //     if ($tutor_advertisement->isClean()) {
    //         return $this->failureResponse('No changes made because no value was supplied', Response::HTTP_NOT_MODIFIED);
    //     }

    //     try {
    //         $tutor_advertisement->save();

    //         return $this->successResponse($tutor_advertisement, Response::HTTP_OK);
    //     } catch (\Throwable $th) {
    //         return $this->failureResponse(
    //             "An error occured and your request couldn't be processed",
    //             Response::HTTP_INTERNAL_SERVER_ERROR
    //         );
    //     }
    // }

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
