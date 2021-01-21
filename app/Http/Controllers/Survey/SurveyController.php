<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Survey;
use Illuminate\Http\Request;

class SurveyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('profile_id')) {
            $survey = Survey::where('profile_id', $request->profile_id)->firstOrFail();
            return $this->singleResponse(new SurveyResource($survey->load(["questions"])));
        } else {
            return $this->collectionResponse(SurveyResource::collection($this->getModel(new Survey, ['questions', 'profile'])));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Survey::where('profile_id', $request->profile_id)->first()) {
            return $this->errorResponse("Encuesta existente");
        }
        $survey = new Survey;
        $survey->profile_id = $request->profile_id;
        $survey->saveOrFail();

        return $this->api_success([
            'data' => new SurveyResource($survey),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return $this->api_success([
            'data' => new SurveyResource($survey),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
