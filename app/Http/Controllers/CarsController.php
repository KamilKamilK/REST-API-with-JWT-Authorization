<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\Validator;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarsController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cars = $this->user->cars()->get(['id','mark', 'description', 'completed', 'created_by']);
        return response()->json($cars->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mark' => 'required|string',
            'description' => 'required|string',
            'completed' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }
        $car = new Car();
        $car->mark = $request->mark;
        $car->description = $request->description;
        $car->completed = $request->completed;

        if ($this->user->cars()->save($car)) {
            return response()->json([
                'status' => true,
                'car' => $car
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Niestety nowy pojazd nie może być zarejestrowany'
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Car $car
     * @return Car
     */
    public function show(Car $car)
    {
        return $car;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Car $car
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, Car $car)
    {
        $validator = Validator::make($request->all(), [
            'mark' => 'required|string',
            'description' => 'required|string',
            'completed' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $car->mark = $request->mark;
        $car->description = $request->description;
        $car->completed = $request->completed;

        if ($this->user->cars()->save($car)) {
            return response()->json([
                'status' => true,
                'car' => $car
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Niestety wybrany pojazd nie może być poprawiny'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Car $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Car $car)
    {
        if ($car->delete()) {
            return response()->json([
                'status' => true,
                'cars' => $car
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Niestety wybrany pojazd nie może być wykasowany'
            ]);
        }
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
