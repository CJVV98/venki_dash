<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostResource;
use App\Post;
use App\PostMedia;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(PostResource::collection($this->getModel(new Post, ['medias', 'user.profile'])));
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
        $post = new Post;
        $post->fill($request->all());
        $post->saveOrFail();
        if ($request->has('medias')) {
            foreach ($request->medias as $file) {
                $postMedia = new PostMedia;
                $image = $file;
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10) . '.jpeg';
                Storage::disk('medias')->put($imageName, base64_decode($image));
                $postMedia->media =  $imageName;
                $postMedia->post_id = $post->id;
                $postMedia->save();
            }
        }

        return $this->api_success([
            'data' => new PostResource($post->load(['medias'])),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->api_success([
            'data' => new PostResource($post),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }
}
