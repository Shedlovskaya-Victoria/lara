<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Flash;

class PostController extends AppBaseController
{
    /**
     * Display a listing of the Post.
     */
    public function index(Request $request)
    {
        /** @var Post $posts */
        $posts = Post::paginate(10);

        return view('posts.index')
            ->with('posts', $posts);
    }


    /**
     * Show the form for creating a new Post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created Post in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $input = $request->all();

        /** @var Post $post */
        $post = Post::create($input);

        Flash::success('Post saved successfully.');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified Post.
     */
    public function show($id)
    {
        /** @var Post $post */
        $post = Post::find($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified Post.
     */
    public function edit($id)
    {
        /** @var Post $post */
        $post = Post::addSelect([
            'category_name'=>Category::select('title')->where('category_id', 'categories.id')
        ])->find($id);
        $categories = Category::all()->pluck('name', 'id');

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }
        return view('posts.edit')->with('post', $post, $categories);
    }

    /**
     * Update the specified Post in storage.
     */
    public function update($id, UpdatePostRequest $request)
    {
        /** @var Post $post */
        $post = Post::find($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        $post->fill($request->all());
        $post->save();

        Flash::success('Post updated successfully.');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified Post from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Post $post */
        $post = Post::find($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        $post->delete();

        Flash::success('Post deleted successfully.');

        return redirect(route('posts.index'));
    }
}
