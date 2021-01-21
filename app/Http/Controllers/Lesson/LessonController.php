<?php

namespace App\Http\Controllers\Lesson;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Lesson;
use Illuminate\Http\Request;

class LessonController extends ApiController
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
    public function store(StoreLessonRequest $request)
    {
        $lesson = new Lesson;
        $lesson->fill($request->all());
        $lesson->saveOrFail();
        return $this->api_success([
            'data' => new LessonResource($lesson),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        return $this->singleResponse(new LessonResource($lesson));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        if ($request->has('course_id')) {
            $lesson->course_id = $request->course_id;
        }
        if ($request->has('name')) {
            $lesson->name = $request->name;
        }
        if ($request->has('description')) {
            $lesson->description = $request->description;
        }
        if ($request->has('duration')) {
            $lesson->description = $request->description;
        }

        if (!$lesson->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $lesson->saveOrFail();

        return $this->api_success([
            'data'      =>  new LessonResource($lesson),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->resources()->delete();
        $lesson->delete();
        return $this->api_success([
            'data'      =>  new LessonResource($lesson),
            'message'   => __('pages.responses.deleted'),
            'code'      =>  201
        ], 201);
    }
}
