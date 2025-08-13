<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with('state.country')->orderBy('name')->paginate(15);
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        // states will be loaded via AJAX after country selection
        return view('cities.create', compact('countries'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string',
        ]);

        // ensure state belongs to country
        $state = State::where('id', $data['state_id'])->where('country_id', $data['country_id'])->first();
        if (!$state) {
            return back()->withErrors(['state_id' => 'Selected state does not belong to selected country'])->withInput();
        }

        $exists = City::where('state_id', $data['state_id'])->where('name', $data['name'])->exists();
        if ($exists) {
            return back()->withErrors(['name' => 'City already exists for selected state'])->withInput();
        }

        City::create(['state_id' => $data['state_id'], 'name' => $data['name']]);
        return redirect()->route('cities.index')->with('success', 'City added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $city->state->country_id)->orderBy('name')->get();
        return view('cities.edit', compact('city', 'countries', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $data = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string',
        ]);

        $state = State::where('id', $data['state_id'])->where('country_id', $data['country_id'])->first();
        if (!$state) {
            return back()->withErrors(['state_id' => 'Selected state does not belong to selected country'])->withInput();
        }

        $exists = City::where('state_id', $data['state_id'])
                      ->where('name', $data['name'])
                      ->where('id', '!=', $city->id)
                      ->exists();
        if ($exists) {
            return back()->withErrors(['name' => 'City already exists for selected state'])->withInput();
        }

        $city->update(['state_id' => $data['state_id'], 'name' => $data['name']]);
        return redirect()->route('cities.index')->with('success', 'City updated.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City deleted.');
    }
// AJAX endpoint: states by country (you can also call StateController)
public function statesByCountry($countryId)
{
    $states = State::where('country_id', $countryId)->orderBy('name')->get();
    return response()->json($states);
}

// AJAX endpoint: cities by state (not strictly needed for creation, but useful)
public function citiesByState($stateId)
{
    $cities = City::where('state_id', $stateId)->orderBy('name')->get();
    return response()->json($cities);
}

}
