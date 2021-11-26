<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;

class StudentQueriesController extends Controller
{
    use StandardizedResponse;

    public function find_school_tutor(Request $request)
    {
        //1. Get all subjects and modules on page load.


        //2. Check if the subject or module exists on the returned list.


        //3. Search for advertisement using the subject_id or module_id.


        //4. Save the searched subject or module in the store or on a cookie.


        //5. Display the subject or modules details on the returned ad results.
    }

    public function find_tutor(Request $request)
    {
        try {
            $advertisements = DB::table('tutor_advertisements')
            ->join('tutor_profiles', 'tutor_advertisements.tutor_id', '=', 'tutor_profiles.tutor_id')
            ->selectRaw('tutor_advertisements.title, tutor_advertisements.content, tutor_advertisements.price, 
            tutor_advertisements.subject_id, tutor_advertisements.max_participants, tutor_advertisements.duration, tutor_advertisements.ad_type,
            tutor_profiles.tutor_id, tutor_profiles.first_name, tutor_profiles.last_name')
            ->where('tutor_advertisements.subject_id', '=', $request['subject_id'])
            ->get();

            return $this->successResponse($advertisements, Response::HTTP_OK);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
