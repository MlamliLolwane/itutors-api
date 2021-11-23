<?php

namespace App\Http\Controllers\GlobalControllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TutoringRequest;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;

class TutoringRequestController extends Controller
{
    use StandardizedResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        //Get all tutoring requets for the tutor
        
        try {
            $tutoring_requests = TutoringRequest::where('tutor_id', $request["tutor_id"])->get();

            return $this->successResponse($tutoring_requests, Response::HTTP_OK);
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
            'student_id' => 'required|integer',
            'tutor_id' => 'required|integer',
            'advertisement_id' => 'required|integer',
            'request_status' => 'string',
            'requested_date' => 'required|string',
            'requested_time' => 'required|string',
            'comment' => 'string'
        ]);

        try {
            $tutoring_request = TutoringRequest::create([
                'student_id' => $request['student_id'],
                'tutor_id' => $request['tutor_id'],
                'advertisement_id' => $request['advertisement_id'],
                'requested_date' => $request['requested_date'],
                'requested_time' => $request['requested_time'],
                'tutorial_joining_url' => $request['tutorial_joining_url'],
                'comment' => $request['comment'],
            ]);

            return $this->successResponse($tutoring_request, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            throw $th;
        }
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
            $tutoring_request = TutoringRequest::find($request["id"]);

            return $this->successResponse($tutoring_request, Response::HTTP_OK);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function tutor_accept_request(Request $request)
    {
        try {
            $tutoring_request = TutoringRequest::find($request["id"]);

            $tutoring_request->request_status = "Accepted";

            $tutoring_request->save();

            return $this->successResponse($tutoring_request, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->failureResponse(
                "An error occured and your request couldn't be processed",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function tutor_reject_request(Request $request)
    {
        try {
            $tutoring_request = TutoringRequest::find($request["id"]);

            $tutoring_request->request_status = "Rejected";

            $tutoring_request->save();

            return $this->successResponse($tutoring_request, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->failureResponse(
                "An error occured and your request couldn't be processed",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function student_cancel_request(Request $request)
    {
        try {
            $tutoring_request = TutoringRequest::find($request["id"]);

            $tutoring_request->request_status = "Cancelled";

            $tutoring_request->save();

            return $this->successResponse($tutoring_request, Response::HTTP_OK);
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
        $tutoring_request = TutoringRequest::find($request['id']);

        $tutoring_request->delete();

        return $this->successResponse("School subject deleted successfully", Response::HTTP_OK);
    }
}
