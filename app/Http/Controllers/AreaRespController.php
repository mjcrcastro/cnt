<?php

namespace App\Http\Controllers;

use App\Models\AreaResp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //name of the action code, a corresponding entry in actions table
        $action_code = 'arearesp_store';
        $message = userCan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
            $input = $request->all();
            
            $this->validate($request, AreaResp::rules);

                //if valid data, create a new Area de Responsabilidad
                $area_resp = AreaResp::create($input);
                //and return to the index
                return redirect()->route('arearesp.index')
                                ->with('message', 'Storage ' . $area_resp->description . ' created');
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
            $filter = $request->search['value'];

            $arearesp = AreaResp::where('description', 'LIKE', "%" . $filter . "%")
                    ->orderBy('description', $request->order[0]['dir'])
                    ->get();

            $response['draw'] = $request->get('draw');

            $response['recordsTotal'] = AreaResp::all()->count();

            $response['recordsFiltered'] = $arearesp->count();

            $response['data'] = array_slice($arearesp->toArray(), $request->get('start'), $request->get('length'));

            return response()->json($response);
        }
    }

}
