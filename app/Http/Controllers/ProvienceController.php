<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provience;
use App\Interfaces\ProvinceRepositoryInterface;
use App\DataTables\ProvinceDataTable;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;

class ProvienceController extends Controller
{   
    private ProvinceRepositoryInterface $provinceRepository;

    public function __construct(ProvinceRepositoryInterface $provinceRepository) 
    {   
        $this->provinceRepository = $provinceRepository;
    }
    
    public function index(ProvinceDataTable $dataTable)
    {
        $province = Provience::get();
        return $dataTable->render('content.province.index',compact('province'));
    }

    public function create()
    {
        $country = Country::get();
        $province = Provience::first();
        return view('content.province.create',compact('country','province'));
    }

    public function store(Request $request) 
    {   
        $request->validate([
            'country_id' => 'required',
            'provience_name' => 'required',
        ]);

        $province = $this->provinceRepository->createProvince($request->all());
        return redirect()->route('province.index')
        ->with('success', 'Province created successfully.');

    }

    public function edit(Provience $province)
    {
        $country = Country::get();   
        return view('content.province.edit', compact('province','country'));
    }

    public function update(Request $request)
    {   
        $provinceId = $request->route('id');
        
        $province = Provience::findOrFail($provinceId);

        $provinceDetails = $request->only([
            'country_id',
            'provience_name'
        ]);

        $provinces = $this->provinceRepository->updateprovince($provinceId,$provinceDetails);
        
        return redirect()->route('province.index')
            ->with('success', 'Province updated successfully');
        
    }

    public function destory($id){
        $province = Provience::findOrFail($id);
        if(Storage::exists('public/assets/'.$province->lincense)){
            Storage::delete('public/assets/'.$province->lincense);
        }
        $this->provinceRepository->deleteProvince($id);

        return true;
    }

    public function getProvience(Request $request){
        $provience = Provience::where('country_id',$request->country_id)->get();
        return response()->json($provience);
    }
}
