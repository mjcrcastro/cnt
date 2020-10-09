<?php

namespace App\Http\Controllers;

use App\Models\AreaResp;
use Illuminate\Http\Request;

class AreaRespController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        return view('arearesp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function show(AreaResp $areaResp) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaResp $areaResp) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AreaResp $areaResp) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaResp $areaResp) {
        //
    }

    public function arearespAjax(Request $request) {


        if ($request->ajax()) {//return json data only to ajax queries
            $filter = $request->get('search.value');

            $arearesp = AreaResp::where('description', 'LIKE', "%" . $filter . "%")->get();

            $response['draw'] = $request->get('draw');

            $response['recordsTotal'] = AreaResp::all()->count();

            $response['recordsFiltered'] = $arearesp->count();

            $response['data'] = array_slice($arearesp->toArray(), $request->get('start'), $request->get('length'));

            return response()->json($response);
        }
    }

}
