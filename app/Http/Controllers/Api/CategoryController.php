<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(): Collection
    {
        return Category::all();
    }

    public function store(CategoryRequest $request): Category
    {
        $category = new Category();
        $request->validated();
        return Category::create($request->only($category->getWritable()));
    }

    public function show(Category $category): Category
    {
        return $category;
    }

    public function update(CategoryRequest $request, Category $category): Category
    {
        $request->validated();
        $category->update($request->only($category->getWritable()));
        return $category;
    }

    public function destroy(Category $category): Response
    {
        $category->delete();
        return response()->noContent();
    }

}
