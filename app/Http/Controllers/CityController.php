<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Provience;
use App\Interfaces\CityRepositoryInterface;
use App\DataTables\CityDataTable;
use Illuminate\Support\Facades\Storage;

class CityController extends Controller
{
    private CityrepositoryInterface $cityRepository;

    public function __construct(CityrepositoryInterface $cityRepository) 
    {   
        $this->cityRepository = $cityRepository;
    }

    public function index(CityDataTable $dataTable)
    {
        $city = City::get();
        return $dataTable->render('content.city.index',compact('city'));
    }

    public function create()
    {
        $city = City::first();
        $province = Provience::get();
        return view('content.city.create',compact('city','province'));
    }

    public function store(Request $request) 
    {   
        $request->validate([
            'provience_id' => 'required',
            'city_title' => 'required',
        ]);

        $city = $this->cityRepository->createCity($request->all());
        return redirect()->route('city.index')
        ->with('success', 'City created successfully.');

    }

    public function edit(City $city)
    {
        $province = Provience::get();
        return view('content.city.edit', compact('province','city'));
    }

    public function update(Request $request)
    {   
        $cityId = $request->route('id');
        
        $city = City::findOrFail($cityId);

        $cityDetails = $request->only([
            'provience_id',
            'city_title'
        ]);

        $cities = $this->cityRepository->updatecity($cityId,$cityDetails);
        
        return redirect()->route('city.index')
            ->with('success', 'City updated successfully');
        
    }

    public function destory($id){
        $city = City::findOrFail($id);
        if(Storage::exists('public/assets/'.$city->lincense)){
            Storage::delete('public/assets/'.$city->lincense);
        }
        $this->cityRepository->deleteCity($id);

        return true;
    }
    
    public function getCity(Request $request){
        $city = City::where('provience_id',$request->provience_id)->get();
        return response()->json($city);
    }
}
