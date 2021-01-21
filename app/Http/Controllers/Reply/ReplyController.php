<?php

namespace App\Http\Controllers\Reply;

use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\User\UserController;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ReplyResource;
use App\Reply;
use App\User;
use Illuminate\Http\Request;

class ReplyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(ReplyResource::collection($this->getModel(new Reply, ['user'])));
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
        $reply = new Reply;
        $reply->fill($request->all());
        $reply->saveOrFail();

        $replies = collect($reply->reply)->groupBy('ct');

        $average = array();
        $replies->each(function ($item, $key) use (&$average) {
            $category = Category::findOrFail($key);
            $average[$category->name] = round(($item->pluck('r')->reduce(function ($carry, $item) {
                return $carry + $item;
            })) / ($item->count()), 3);
        });

        /**Update user surveyed */
        $userRequest = new UpdateUserRequest;

        foreach($average as $skill){
            switch ($skill) {
                case 'value':
                   
                    break;
                
            }
        }

        $userRequest->request->add(["surveyed" => 1]);
        $user = User::find($reply->user_id);
        $userController = new UserController;
        $userController->update($userRequest, $user);

        return $this->api_success([
            'data' => new ReplyResource($reply),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        $replies = collect($reply->reply)->groupBy('ct');

        $average = array();
        $replies->each(function ($item, $key) use (&$average) {
            $category = Category::findOrFail($key);
            $average[$category->name] = round(($item->pluck('r')->reduce(function ($carry, $item) {
                return $carry + $item;
            })) / ($item->count()), 3);
        });
        $reply = $reply->load(['user.courses', 'survey.profile'])->toArray();
        $reply["reply"] = $average;
        return $this->singleResponse(new ReplyResource($reply));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        if ($request->has('scored')) {
            $reply->scored = $request->scored;
        }

        if (!$reply->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $reply->saveOrFail();

        return $this->api_success([
            'data'      =>  new ReplyResource($reply),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->delete();
        return $this->api_success([
            'data' => new ReplyResource($reply),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
