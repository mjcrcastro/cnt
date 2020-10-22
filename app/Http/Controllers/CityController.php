<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $country = Country::find($request->country_id);
        if (!($country)) {
            return redirect()->route('countries.index')->with('message', 'Seleccione un País');
        }
        
        //Lista todas las ciudades de un pais (country_id)
        return view('city.index', compact('country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
         //Display new City Form
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('msg', $message);
        }
        $country = Country::find($request->country_id);
        if (!($country)) {
            return redirect()->route('countries.index')->with('message', 'Seleccione un País');
        }
        return view('city.create', compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //name of the action code, a corresponding entry in actions table
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string

        $message = userCan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        $request->merge(['created_by' => 'default created']);
        $request->merge(['updated_by' => 'default created']);
        $request->validate(array(
            'description' => ['required', Rule::unique('cities')->where(function ($query) use($request) {
                            return $query->where('country_id', '=',$request->country_id);
                        })],
            'country_id' => 'required'
        ));
        //if valid data, create a new Area de Responsabilidad
        $city = City::create($request->all());
        $country_id = $request->country_id; //el indice requiere el area de responsabilidad
        //and return to the index
        return redirect()->route('cities.index', compact('country_id'))
                        ->with('message', 'Ciudad ' . $city->description . ' registrada');
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
    public function edit($id)
    {
         //Redirect to City editor
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) { //I the user does not have permissions
            return redirect()->back()->with('message', $message);
        }
        
        $city = City::find($id);
        
        if (is_null($city)) { //if no Cost City is found
            return redirect()->route('countries.index'); //go to previous page
        }
        
        $country = Country::find($city->country_id);

        //otherwise display the city editor view
        return view('city.edit', compact('country','city'));
        // End of actual code to execute
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        
        //make sure the description is unique but 
        //exclude the $id for the current shop
        $request->merge(['updated_by' => 'default created']);
        $request->validate(array(
            'description' => ['required', Rule::unique('cities')->where(function ($query) use($request, $id) {
                            return $query->where('country_id', '=',$request->country_id)
                                         ->where('id','<>',$id);
                        })],
            'country_id' => 'required'
        ));
        $city = City::find($id);
        $city->update($request->all());
        $country_id =$city->country_id;
        return redirect()->route('cities.index',compact('country_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        $country_id = City::find($id)->country_id;
        City::find($id)->delete();
        return redirect()->route('cities.index',compact('country_id'));
    }
    
    public function citiesAjax(Request $request) {

        if ($request->ajax()) {//return json data only to ajax queries 
        $filter = $request->search['value'];
        $cities = City::where('country_id', '=', $request->country_id)
                ->where('description', 'LIKE', "%" . $filter . "%")
                ->orderBy('description', $request->order[0]['dir'])
                ->get();

        $response['draw'] = $request->get('draw');

        $response['recordsTotal'] = City::where('country_id', '=', $request->country_id)->count();

        $response['recordsFiltered'] = $cities->count();

        $response['data'] = array_slice($cities->toArray(), $request->get('start'), $request->get('length'));
        return response()->json($response);
        }
    }
}
