<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\QuestionResource;
use App\Profile;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $question = new Question;
        $question->fill($request->all());

        if ($request->has("profile_id")) {
            $survey =  Profile::findOrFail($request->profile_id)->surveys()->first();
            $question->survey_id = $survey->id;
        }

        $question->saveOrFail();

        return $this->api_success([
            'data' => new QuestionResource($question),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        if ($request->has("profile_id")) {
            $survey =  Profile::findOrFail($request->profile_id)->surveys()->first();
            $question->survey_id = $survey->id;
        }

        if ($request->has("question")) {
            $question->question = $request->question;
        }

        if ($request->has("survey_id")) {
            $question->survey_id = $request->survey_id;
        }
        
        if ($request->has("category_id")) {
            $question->category_id = $request->category_id;
        }

        if (!$question->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $question->saveOrFail();

        return $this->api_success([
            'data'      =>  new QuestionResource($question),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return $this->api_success([
            'data' => new QuestionResource($question),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
