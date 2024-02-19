<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Tag;
use Illuminate\Http\Request;
use Flash;

class TagController extends AppBaseController
{
    /**
     * Display a listing of the Tag.
     */
    public function index(Request $request)
    {
        /** @var Tag $tags */
        $tags = Tag::paginate(10);

        return view('tags.index')
            ->with('tags', $tags);
    }


    /**
     * Show the form for creating a new Tag.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created Tag in storage.
     */
    public function store(CreateTagRequest $request)
    {
        $input = $request->all();

        /** @var Tag $tag */
        $tag = Tag::create($input);

        Flash::success('Tag saved successfully.');

        return redirect(route('tags.index'));
    }

    /**
     * Display the specified Tag.
     */
    public function show($id)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            Flash::error('Tag not found');

            return redirect(route('tags.index'));
        }

        return view('tags.show')->with('tag', $tag);
    }

    /**
     * Show the form for editing the specified Tag.
     */
    public function edit($id)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            Flash::error('Tag not found');

            return redirect(route('tags.index'));
        }

        return view('tags.edit')->with('tag', $tag);
    }

    /**
     * Update the specified Tag in storage.
     */
    public function update($id, UpdateTagRequest $request)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            Flash::error('Tag not found');

            return redirect(route('tags.index'));
        }

        $tag->fill($request->all());
        $tag->save();

        Flash::success('Tag updated successfully.');

        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified Tag from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            Flash::error('Tag not found');

            return redirect(route('tags.index'));
        }

        $tag->delete();

        Flash::success('Tag deleted successfully.');

        return redirect(route('tags.index'));
    }
}
