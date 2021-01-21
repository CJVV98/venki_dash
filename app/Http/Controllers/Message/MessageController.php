<?php

namespace App\Http\Controllers\Message;

use App\Events\ChatEvent;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\MessageResource;
use App\Message;
use App\Traits\MessagePush;
use Illuminate\Http\Request;

class MessageController extends ApiController
{

    use MessagePush;
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
        $message = new Message;
        $message->fill($request->all());
        $message->saveOrFail();

        $token = null;
        $name = "Usuario";

        if ($message->chat->receiver_id == $message->user_id) {
            $token = $message->chat->transmitter->devices()->latest()->first()->code;
            $name = $message->chat->transmitter->name;
        } else {
            $token = $message->chat->receiver->devices()->latest()->first()->code;
            $name = $message->chat->receiver->name;
        }
        if ($token) {
            $this->sendPush($message->message, $token, $name);
        }
        event(new ChatEvent($message));
        return $this->api_success([
            'data' => new MessageResource($message),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
