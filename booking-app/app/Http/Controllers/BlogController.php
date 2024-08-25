<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'image' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
            'categories' => 'required|string',
            'tags' => 'required|string',
        ]);

        $blog = Blog::create($request->all());
        return response()->json($blog, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'sometimes|string|max:255',
            'image' => 'sometimes|string',
            'date' => 'sometimes|date',
            'description' => 'sometimes|string',
            'categories' => 'sometimes|string',
            'tags' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        $blog->update($request->all());

        return response()->json($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Supprime un blog par son ID
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }

    public function Tags()
    {
        $allTags = Blog::pluck('tags')->toArray();

        $tagsArray = [];
        foreach ($allTags as $tags) {
            $tagsArray = array_merge($tagsArray, explode('|', $tags));
        }

        $uniqueTags = array_unique($tagsArray);

        shuffle($uniqueTags);
        $randomTags = array_slice($uniqueTags, 0, 10);

        return response()->json($randomTags);
    }
    public function Categories()
    {
        $allCategories = Blog::pluck('categories')->toArray();

        $categoriesArray = [];
        foreach ($allCategories as $categories) {
            $categoriesArray = array_merge($categoriesArray, explode('|', $categories));
        }

        $uniqueCategories = array_unique($categoriesArray);

        shuffle($uniqueCategories);
        $randomCategories = array_slice($uniqueCategories, 0, 10);

        return response()->json($randomCategories);
    }

    public function alea()
    {
        $blogs = Blog::inRandomOrder()->take(3)->get();
        return response()->json($blogs);
    }

}
