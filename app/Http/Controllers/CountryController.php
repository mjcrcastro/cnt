<?php

namespace App\Http\Controllers;

use App\Models\country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Show list of countries
        return view('country.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Display new country Form
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        return view('country.create');
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

        $request->validate(Country::$createRules);

        //if valid data, create a new country entry
        $country = Country::create($request->all());
        //and return to the index
        return redirect()->route('countries.index')
                        ->with('message', 'País ' . $country->description . ' Registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Redirect to country editor
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) { //I the user does not have permissions
            return redirect()->back()->with('message', $message);
        }

        $country = Country::find($id);

        if (is_null($country)) { //if no shop is found
            return redirect()->route('countries.index'); //go to previous page
        }

        //otherwise display the shop editor view
        return view('country.edit', compact('country'));
        // End of actual code to execute
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ///
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        //make sure the description is unique but 
        //exclude the $id for the current shop
        $request->validate(['description' => 'required|unique:countries,description,' . $id . 'id']);

        $countries = Country::find($id);
        $countries->update($request->all());
        return redirect()->route('countries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        Country::find($id)->delete();
        return redirect()->route('countries.index');
    }
    
     public function countriesAjax(Request $request) {
        //returns list of countries
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->withErrors('message', $message);
        }
        if ($request->ajax()) {//return json data only to ajax queries 
            $filter = $request->search['value'];

            $country = Country::where('description', 'LIKE', "%" . $filter . "%")
                    ->orderBy('description', $request->order[0]['dir'])
                    ->get();

            $response['draw'] = $request->get('draw');

            $response['recordsTotal'] = Country::all()->count();

            $response['recordsFiltered'] = $country->count();

            $response['data'] = array_slice($country->toArray(), $request->get('start'), $request->get('length'));

            return response()->json($response);
        }
    }
}
