<?php

namespace App\Http\Controllers\DailyActivity;

use App\DailyActivity;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyActivityResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyActivityController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('today')) {
            $dailyActivity = DailyActivity::orderBy('last_done', 'asc')->first();
            $dailyActivity->last_done = Carbon::now();
            $dailyActivity->saveOrFail();
            return $this->singleResponse(new DailyActivityResource($dailyActivity));
        }
        return $this->collectionResponse(DailyActivityResource::collection($this->getModel(new DailyActivity, [])));
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
        $dailyActivity = new DailyActivity;
        $dailyActivity->fill($request->all());
        $dailyActivity->saveOrFail();

        return $this->api_success([
            'data'      =>  new DailyActivityResource($dailyActivity),
            'message'   => __('pages.responses.created'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function show(DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyActivity $dailyActivity)
    {
        //
    }
}
