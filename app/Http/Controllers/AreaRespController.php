<?php

namespace App\Http\Controllers;

use App\Models\AreaResp;
use Illuminate\Http\Request;

class AreaRespController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('arearesp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function show(AreaResp $areaResp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaResp $areaResp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AreaResp $areaResp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaResp $areaResp)
    {
        //
    }
}
