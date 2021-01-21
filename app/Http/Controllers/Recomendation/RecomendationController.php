<?php

namespace App\Http\Controllers\Recomendation;

use App\Course;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecomendationResource;
use App\Recomendation;
use Illuminate\Http\Request;

class RecomendationController extends ApiController
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
        $recomendation = new Recomendation;
        $recomendation->fill($request->all());
        $recomendation->saveOrFail();
        if ($request->has("courses")) {
            $courses = Course::whereIn('id', $request->courses)->get();
            $recomendation->courses()->attach($courses);
        }

        return $this->api_success([
            'data' => new RecomendationResource($recomendation),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recomendation  $recomendation
     * @return \Illuminate\Http\Response
     */
    public function show(Recomendation $recomendation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recomendation  $recomendation
     * @return \Illuminate\Http\Response
     */
    public function edit(Recomendation $recomendation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recomendation  $recomendation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recomendation $recomendation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recomendation  $recomendation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recomendation $recomendation)
    {
        $recomendation->delete();
        return $this->api_success([
            'data' => new RecomendationResource($recomendation),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }
}
