<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provience;
class ProvienceController extends Controller
{
    public function getProvience(Request $request){
        $provience = Provience::where('country_id',$request->country_id)->get();
        return response()->json($provience);
    }
}
