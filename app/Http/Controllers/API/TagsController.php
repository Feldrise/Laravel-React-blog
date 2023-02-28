<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Tag;
use Illuminate\Http\Request;
use Validator;

class TagsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->input('all')) {
            $tags = Tag::all();
        }
        else {
            // $tags = Tag::paginate(10);
            $tags = [];
        }

        return $this->sendResponse($tags, '');
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

        $tag = Tag::create([
            'title' => $request->title,
        ]);

        return $this->sendResponse($tag, 'Tag created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return $this->sendResponse($tag, '');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $tag->update([
            'title' => $request->title,
        ]);

        return $this->sendResponse($tag, 'Tag updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->sendResponse([], 'Tag deleted successfully', 204);
    }
}
