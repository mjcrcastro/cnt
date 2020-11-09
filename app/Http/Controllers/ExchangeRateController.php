<?php

namespace App\Http\Controllers;

use App\Models\exchangerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///Show list of exchangeRates
        return view('exchangerate.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //Display new exchange rate Form
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        return view('exchangerate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\exchangerate  $exchangerate
     * @return \Illuminate\Http\Response
     */
    public function show(exchangerate $exchangerate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exchangerate  $exchangerate
     * @return \Illuminate\Http\Response
     */
    public function edit(exchangerate $exchangerate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\exchangerate  $exchangerate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, exchangerate $exchangerate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\exchangerate  $exchangerate
     * @return \Illuminate\Http\Response
     */
    public function destroy(exchangerate $exchangerate)
    {
        //
    }
    
    public function exchangeratesAjax(Request $request) {
        //returns list of countries
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->withErrors('message', $message);
        }
        if ($request->ajax()) {//return json data only to ajax queries 
            $filter = $request->search['value'];

            $exchange_rate = ExchangeRate::where('rate_date', 'LIKE', "%" . $filter . "%")
                    ->orderBy('rate_date', $request->order[0]['dir'])
                    ->get();

            $response['draw'] = $request->get('draw');

            $response['recordsTotal'] = ExchangeRate::all()->count();

            $response['recordsFiltered'] = $exchange_rate->count();

            $response['data'] = array_slice($exchange_rate->toArray(), $request->get('start'), $request->get('length'));

            return response()->json($response);
        }
    }
}
