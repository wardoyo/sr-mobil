<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Merk;
use \App\Models\Category;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merk = Merk::paginate(10);
        return view('merks.index', ['merks' => $merk]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('merks.create', ['categories' => $categories]);
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
        $category = $request->get('category');
        $spek = $request->get('specification');

        $merk = new Merk;
        $merk->name = $name;
        $merk->category_id = $category;
        if ($request->file('image')) {
            $image_path = $request->file('image')->store('merk_images', 'public');
            $merk->image = $image_path;
        }

        $merk->created_by = \Auth::user()->id;
        $merk->specification = $spek;
        $merk->save();

        return redirect()->route('merks.create')->with('status', 'Merk '.$name.' successfully Created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $merk = Merk::findOrFail($id);

        return view('merks.show', ['merk' => $merk]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merk = Merk::findOrFail($id);
        $categories = Category::all();

        return view('merks.edit', ['merk' => $merk, 'categories' => $categories]);
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
        $category_id = $request->get('category');
        $new_image = $request->file('image');
        $spek = $request->get('specification');

        $merk = Merk::findOrFail($id);
        $merk->name = $name;
        $merk->category_id = $category_id;
        if ($new_image) {
            if ($merk->image && file_exists(storage_path('app/public/'.$merk->image))) {
                \Storage::delete(['public/'.$merk->image]);
            }
            $new_image_path = $new_image->store('merk_images', 'public');
            $merk->image = $new_image_path;
        }

        $merk->specification = $spek;
        $merk->updated_by = \Auth::user()->id;
        $merk->save();

        return redirect()->route('merks.edit', [$merk->id])->with('status', 'Merk '.$merk->name.' successfully Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merk = Merk::findOrFail($id);

        $merk->deleted_by = \Auth::user()->id;
        $merk->save();
        $merk->delete();

        return redirect()->route('merks.index')->with('status', 'Merk '.$merk->name.' successfully trashed');
    }

    public function trash()
    {
        $merks = Merk::onlyTrashed()->paginate(10);
        return view('merks.trash', ['merks' => $merks]);;
    }

    public function restore($id)
    {
        $merk = Merk::withTrashed()->findOrFail($id);

        if ($merk->trashed()) {
            $merk->deleted_by = null;
            $merk->deleted_at = null;
            $merk->save();
            $merk->restore();
        } else{
            return redirect()->route('merks.index')->with('status', 'Merk not in trash');
        }
        return redirect()->route('merks.index')->with('status', 'Merk '.$merk->name.' successfully restored');
    }

    public function deletePermanent($id)
    {
        $merk = Merk::withTrashed()->findOrFail($id);

        if(!$merk->trashed()){
            return redirect()->route('merks.index')->with('status', 'Can not delete active Merk');
        } else{
            $merk->forceDelete();
            return redirect()->route('merks.index')->with('status', 'Merk '.$merk->name.' permanently deleted');
        }
    }
}
