<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CountryRepositoryInterface;
use App\DataTables\CountryDataTable;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    private CountryRepositoryInterface $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository) 
    {   
        $this->countryRepository = $countryRepository;
    }

    public function index(CountryDataTable $dataTable)
    {
        $country = Country::get();
        return $dataTable->render('content.country.index',compact('country'));
    }

    public function create()
    {
        $country = Country::first();

        return view('content.country.create',compact('country'));
    }

    public function store(Request $request) 
    {   
        $request->validate([
            'name' => 'required',
            'country_code' => 'required|unique:countries,country_code',
        ]);

        $country = $this->countryRepository->createCountry($request->all());
        return redirect()->route('country.index')
        ->with('success', 'Country created successfully.');

    }

    public function edit(Country $country)
    {
        
        $country = Country::where('id',$country->id)->first();

        return view('content.country.edit', compact('country'));
    }

    public function update(Request $request)
    {   
        $countryId = $request->route('id');
        
        $country = Country::findOrFail($countryId);

        $countryDetails = $request->only([
            'name',
            'country_code'
        ]);

        $countries = $this->countryRepository->updateCountry($countryId,$countryDetails);
        
        return redirect()->route('country.index')
            ->with('success', 'Country updated successfully');
        
    }

    public function destory($id){

        $country = Country::findOrFail($id);
        if(Storage::exists('public/assets/'.$country->lincense)){
            Storage::delete('public/assets/'.$country->lincense);
        }
        $this->countryRepository->deleteCountry($id);

        return true;
    }


}
