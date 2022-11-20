<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
class CityController extends Controller
{
    public function getCity(Request $request){
        $city = City::where('provience_id',$request->provience_id)->get();
        return response()->json($city);
    }
}
