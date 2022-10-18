<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Merk;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::paginate(10);

        return view('cars.index',['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merks = Merk::all();
        return view('cars.create', ['merks' => $merks]);
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
        $merk = $request->get('merk');
        $price = $request->get('price');

        $car = new Car;
        $car->name = $name;
        $car->merk_id = $merk;
        $car->price = $price;
        $car->created_by = \Auth::user()->id;
        $car->save();

        return redirect()->route('cars.create')->with('status', 'Car '.$name.' successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);

        return view('cars.show', ['car' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $merks = Merk::all();

        return view('cars.edit', ['car' => $car, 'merks' => $merks]);
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
        $merk = $request->get('merk');
        $price = $request->get('price');

        $car = Car::findOrFail($id);
        $car->name = $name;
        $car->merk_id = $merk;
        $car->price = $price;
        $car->updated_by = \Auth::user()->id;
        $car->save();

        return redirect()->route('cars.edit', ['car' => $car])->with('status', 'Car '.$name.' successfully Updated' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->deleted_by = \Auth::user()->id;
        $car->save();
        $car->delete();

        return redirect()->route('cars.index')->with('status', 'Car '.$car->name.' successfully trashed');
    }

    public function trash()
    {
        $cars = Car::onlyTrashed()->paginate(10);

        return view('cars.trash', ['cars' => $cars]);
    }

    public function restore($id)
    {
        $car = Car::withTrashed()->findOrFail($id);

        if (!$car->trashed()) {
            return redirect()->route('cars.index')->with('status', 'Car is not in trash');
        } else{
            $car->deleted_by = null;
            $car->deleted_at = null;
            $car->save();
            $car->restore();

            return redirect()->route('cars.index')->with('status', 'Car '.$car->name.' successfully restored');
        }
    }

    public function deletePermanent($id)
    {
        $car = Car::withTrashed()->findOrFail($id);

        if (!$car->trashed()) {
            return redirect()->route('cars.index')->with('status', 'Can not delete active car');
        } else{
            $car->forceDelete();
            return redirect()->route('cars.index')->with('status', 'Car permanently deleted');
        }
    }
}
