<?php

namespace App\Http\Controllers\GlobalControllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UniversityModule;
use App\Http\Controllers\Controller;

class UniversityModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $university_module = UniversityModule::all();

            return $this->successResponse($university_module, Response::HTTP_OK);
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
            'module_code' => 'required|string',
            'module_name' => 'required|string',
            'university' => 'required|string',
        ]);

        try {
            $university_module = UniversityModule::create([
                'module_name' => $request['module_name'],
                'university' => $request['university'],
            ]);

            return $this->successResponse($university_module, Response::HTTP_CREATED);
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
            $university_module = UniversityModule::find($request["id"]);

            return $this->successResponse($university_module, Response::HTTP_OK);
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
    public function update(Request $request, $id)
    {
        try {
            $university_module = UniversityModule::find($request["id"]);

            $university_module->fill($request->all());

            if ($university_module->isClean()) {
                return $this->failureResponse('No changes made because no value was supplied', Response::HTTP_NOT_MODIFIED);
            }

            $university_module->save();

            return $this->successResponse($university_module, Response::HTTP_OK);
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
        $university_module = UniversityModule::find($request['id']);

        $university_module->delete();

        return $this->successResponse("University module deleted successfully", Response::HTTP_OK);
    }
}
