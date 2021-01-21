<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(CategoryResource::collection($this->getModel(new Category, [])));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category;
        $category->fill($request->all());

        if ($request->hasFile('photo')) {
            $category->photo = $request->photo->store('images');
        }
        $category->saveOrFail();

        return $this->api_success([
            'data' => new CategoryResource($category),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->singleResponse(new CategoryResource($category));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($request->has("name")) {
            $category->name = $request->name;
        }
        if ($request->has("video")) {
            $category->video = $request->video;
        }
        if ($request->has("description")) {
            $category->description = $request->description;
        }
        if ($request->has("pdf")) {
            $category->pdf = $request->pdf;
        }
        if ($request->has("photo")) {
            Storage::delete($category->photo);
            $category->photo = $request->photo->store('images');
        }


        if (!$category->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $category->saveOrFail();

        return $this->api_success([
            'data'      =>  new CategoryResource($category),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->singleResponse(new CategoryResource($category), 200);
    }
}
