<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Category;
use Illuminate\Http\Request;
use Flash;

class CategoryController extends AppBaseController
{
    /**
     * Display a listing of the Category.
     */
    public function index(Request $request)
    {
        /** @var Category $categories */
        $categories = Category::paginate(10);

        return view('categories.index')
            ->with('categories', $categories);
    }


    /**
     * Show the form for creating a new Category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created Category in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        /** @var Category $category */
        $category = Category::create($input);

        Flash::success('Category saved successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified Category.
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     */
    public function edit($id)
    {
        /** @var Category $category */
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified Category in storage.
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        /** @var Category $category */
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $category->fill($request->all());
        $category->save();

        Flash::success('Category updated successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $category->delete();

        Flash::success('Category deleted successfully.');

        return redirect(route('categories.index'));
    }
}
