<?php

namespace App\Http\Controllers\Tutor;

use Illuminate\Http\Request;
use App\Models\TutorSchedule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;

class TutorScheduleController extends Controller
{
    use StandardizedResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tutor_id)
    {
        try {
            $tutor_schedule = DB::table('days')
                ->leftJoin('tutor_schedules', 'days.id', '=', 'tutor_schedules.day_id')
                ->select('tutor_schedules.*', 'days.day_name')
                ->orderBy('days.id')
                ->get();

            return $this->successResponse($tutor_schedule, Response::HTTP_OK);
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
            'tutor_id' => 'required|integer',
            'day_id' => 'required|integer',
            'schedule' => 'required|string',
        ]);

        //Might consider storing the JSON object in the database for performance reasons.
        $tutor_schedule = TutorSchedule::create([
            'tutor_id' => $request['tutor_id'],
            'day_id' => $request['day_id'],
            'schedule' => $request['schedule']
        ]);

        return $this->successResponse($tutor_schedule, Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TutorSchedule  $tutorSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**
         * Soft delete the previous schedule details and create a new one for the tutor to prevent
         * data inaccuracy issues.
         */
        //Find the schedule with it's id
        //$tutor_schedule = TutorSchedule::find($request['id']);
        $updated_schedule = $request->validate([
            'schedule' => 'required'
        ]);

        /**
         * Create a new schedule for the same day the tutor specified.
         */
        $tutor_schedule = TutorSchedule::where('id', $id)->first();

        $tutor_schedule->fill($updated_schedule);

        $tutor_schedule->save();

        return $this->successResponse($tutor_schedule, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TutorSchedule  $tutorSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Find the schedule with it's id
        $tutor_schedule = TutorSchedule::find($request['id']);

        //Delete the schedule
        $tutor_schedule->delete();

        return $this->successResponse('Schedule deleted successfully', Response::HTTP_OK);
    }
}
