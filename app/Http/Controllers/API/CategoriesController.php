<?php

namespace App\Http\Controllers\API;

use App\Lib\Helper;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoriesController extends BaseController
{
    use Helper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return $this->sendResponse($categories, '');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $category = Category::create([
            'title' => $request->title,
            'slug' => $this->slugify($request->title),
        ]);

        return $this->sendResponse($category, 'Category created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->sendResponse($category, '');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $category->update([
            'title' => $request->title,
            'slug' => $this->slugify($request->title),
        ]);

        return $this->sendResponse($category, 'Category updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->sendResponse([], 'Category deleted successfully', 200);
    }
}
