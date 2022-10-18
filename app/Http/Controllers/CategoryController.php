<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');

        $new_category = new Category;
        $new_category->name = $name;
        $new_category->created_by = \Auth::user()->id;
        $new_category->save();

        return redirect()->route('categories.create')->with('status', 'Category '.$name.' successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view ('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->get('name');

        $category = Category::findOrFail($id);
        $category->name = $name;
        $category->updated_by = \Auth::user()->id;
        $category->save();

        return redirect()->route('categories.edit', [$id])->with('status', 'Category '.$name.' successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->deleted_by = \Auth::user()->id;
        $category->save();
        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category '.$category->name.' successfully Trashed');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(10);

        return view('categories.trash', ['categories' => $categories]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if ($category->trashed()) {
            $category->deleted_by = null;
            $category->deleted_at = null;
            $category->save();
            $category->restore();
        } else{
            return redirect()->route('categories.index')->with('status', 'Category is not in trash');
        }

        return redirect()->route('categories.index')->with('status', 'Category '.$category->name.' successfully restored');
    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if (!$category->trashed()) {
            return redirect()->route('categories.index')->with('status', 'Can not delete active category');
        }else{
            $category->forceDelete();

            return redirect()->route('categories.index')->with('status', 'Category permanently Deleted ');
        }

    }
}
