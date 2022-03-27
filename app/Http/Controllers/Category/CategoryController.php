<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $Categories = Category::all();
        return $this->showAll($Categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $Category = Category::query()->create($validated);
        return $this->showOne($Category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->only(['name','description']));

        if ($category->isClean()) {
            return $this->errorResponse('you must change less one field', Response::HTTP_BAD_REQUEST);
        }
        $category->save();
        return $this->showOne($category,202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showOne($category);
    }
}
