<?php

namespace App\Http\Controllers\Achievement;

use App\Achievement;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievementResource;
use Illuminate\Http\Request;

class AchievementController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(AchievementResource::collection($this->getModel(new Achievement, [])));
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
        $achievement = new Achievement;
        $achievement->fill($request->all());
        $achievement->saveOrFail();

        return $this->api_success([
            'data'      =>  new AchievementResource($achievement),
            'message'   => __('pages.responses.created'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function show(Achievement $achievement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function edit(Achievement $achievement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achievement $achievement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();
        return $this->api_success([
            'data'      =>  new AchievementResource($achievement),
            'message'   => __('pages.responses.deleted'),
            'code'      =>  201
        ], 201);
    }
}
