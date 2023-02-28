<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Lib\Helper;
use App\Models\Post;
use Illuminate\Http\Request;
use Validator;

class PostsController extends BaseController
{
    use Helper;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->input('recent')) {   // in case of recent posts in website homepage
            $posts = Post::with('category', 'user', 'tags')->where('published', 1)->orderBy('id', 'DESC')->limit(7)->get();
        }
        else if($request->input('category')) {   // in case of posts per category page
             $posts = Post::with('category', 'user', 'tags')->whereHas('category', function ($query) use ($request) {
                 $query->where('id', $request->category);
             })->where('published', 1)->orderBy('id', 'DESC')->paginate(10);
         }
         else if($request->input('tag')) {    // in case of posts per tag page
            $posts = Post::with('category', 'user', 'tags')->whereHas('tags', function ($query) use ($request) {
                $query->where('id', $request->input('tag'));
            })->where('published', 1)->orderBy('id', 'DESC')->paginate(10);
        }
        else {   // the default case for the admin posts
            $posts = Post::with('category', 'user', 'tags')->orderBy('id', 'DESC')->paginate(10);
         }

         return $this->sendResponse($posts, '');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            // 'image' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => $this->slugify($request->title),
            'content' => $request->content,
            'image' => 'temps.png',
            'published' => $request->published ? $request->published : 0,
            'category_id' => $request->category_id,
            'user_id' => 1,
        ]);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        $post = Post::with('tags')->find($post->id);

        return $this->sendResponse($post, 'Post created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
