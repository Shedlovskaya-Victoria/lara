<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = Post::latest()->paginate(15);

        $posts = Post::addSelect(
            [
                'category_name' => Category::select('title')
                    ->whereColumn('category_id', 'categories.id'),
                'category_slug' => Category::select('slug')
                    ->whereColumn('category_id', 'categories.id'),
            ]
        )->paginate(15);

//dd($posts->find(1));

      //  $categories = Category::withCount('posts')->get();
       // $categories = Category::with(['posts'])->get();
       // $latestPosts = Post::orderByDesc('id')->limit(5)->get();
        return view('frontend.blog', ['posts'=>$posts]);
       // return view('frontend.blog', ['posts'=>$posts, 'categories'=>$categories ,'latestPosts'=>$latestPosts]);
    }


    public function postInCategory(Category $category)
    {
       // $posts = Post::where('category_id', $category->id)->get();
        $posts = $category->posts()->addSelect(
            [
                'category_name' => Category::select('title')
                    ->whereColumn('category_id', 'categories.id'),
                'category_slug' => Category::select('slug')
                    ->whereColumn('category_id', 'categories.id'),
            ]
        )->latest()->paginate(15);
      //   $categories = Category::withCount('posts')->get();
      //  $latestPosts = Post::orderByDesc('id')->limit(5)->get();
        return view('frontend.blog', compact('posts'));
       // return view('frontend.blog', compact('posts','categories','latestPosts'));
        //
    }
  public function postInTag(Tag $tag)
    {
       // $posts = Post::where('category_id', $category->id)->get();
        $posts = $tag->posts()->addSelect(
            [
                'category_name' => Category::select('title')
                    ->whereColumn('category_id', 'categories.id'),
                'category_slug' => Category::select('slug')
                    ->whereColumn('category_id', 'categories.id'),
            ]
        )->latest()->paginate(15);
      //   $categories = Category::withCount('posts')->get();
      //  $latestPosts = Post::orderByDesc('id')->limit(5)->get();
        return view('frontend.blog', compact('posts'));
       // return view('frontend.blog', compact('posts','categories','latestPosts'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //$post = Post::find($id);
        $latestPosts = Post::orderByDesc('id')->limit(5)->get();
        $categories = Category::withCount('posts')->get();
        return view('frontend.blog-single', compact('post', 'categories', 'latestPosts'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
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
