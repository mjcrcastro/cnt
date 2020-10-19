<?php

namespace App\Http\Controllers;

use App\Models\AreaResp;
use App\Models\CostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class CostCenterController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $arearesp = AreaResp::find($request->area_resp_id);
        if (!($arearesp)) {
            return redirect()->route('arearesp.index')->with('message', 'Seleccione un Area de Responsabilidad');
        }
        
        //return $arearesp;

        //Lista todos los centros de análisis de un area de responsabilidad (area_resp_id)
        return view('costCenters.index', compact('arearesp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        //Display new costCenter Form
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('msg', $message);
        }
        $arearesp = AreaResp::find($request->area_resp_id);
        if (!($arearesp)) {
            return redirect()->route('arearesp.index')->with('message', 'Seleccione un Area de Responsabilidad');
        }
        return view('costCenters.create', compact('arearesp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //name of the action code, a corresponding entry in actions table
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string

        $message = userCan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        $request->merge(['created_by' => 'default created']);
        $request->merge(['updated_by' => 'default created']);
        $request->validate(array(
            'description' => ['required', Rule::unique('cost_centers')->where(function ($query) use($request) {
                            return $query->where('area_resp_id', '=',$request->area_resp_id);
                        })],
            'area_resp_id' => 'required'
        ));
        //if valid data, create a new Area de Responsabilidad
        $costCenter = CostCenter::create($request->all());
        $area_resp_id = $request->area_resp_id; //el indice requiere el area de responsabilidad
        //and return to the index
        return redirect()->route('costCenters.index', compact('area_resp_id'))
                        ->with('message', 'Centro de Costo ' . $costCenter->description . ' registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function show() {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
         //Redirect to arearesp editor
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) { //I the user does not have permissions
            return redirect()->back()->with('message', $message);
        }
        
        $costCenter = CostCenter::find($id);
        
        if (is_null($costCenter)) { //if no Cost Center is found
            return redirect()->route('arearesp.index'); //go to previous page
        }
        
        $arearesp = AreaResp::find($costCenter->area_resp_id);

        //otherwise display the shop editor view
        return view('costCenters.edit', compact('arearesp','costCenter'));
        // End of actual code to execute
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        
        //make sure the description is unique but 
        //exclude the $id for the current shop
        $request->merge(['updated_by' => 'default created']);
        $request->validate(array(
            'description' => ['required', Rule::unique('cost_centers')->where(function ($query) use($request, $id) {
                            return $query->where('area_resp_id', '=',$request->area_resp_id)
                                         ->where('id','<>',$id);
                        })],
            'area_resp_id' => 'required'
        ));
        $costCenter = CostCenter::find($id);
        $costCenter->update($request->all());
        $area_resp_id =$costCenter->area_resp_id;
        return redirect()->route('costCenters.index',compact('area_resp_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostCenter $costCenter) {
        //
    }

    public function costCenterAjax(Request $request) {

        //if ($request->ajax()) {//return json data only to ajax queries 
        $filter = $request->search['value'];
        $centros = CostCenter::where('area_resp_id', '=', $request->area_resp_id)
                ->where('description', 'LIKE', "%" . $filter . "%")
                ->orderBy('description', $request->order[0]['dir'])
                ->get();

        $response['draw'] = $request->get('draw');

        $response['recordsTotal'] = CostCenter::where('area_resp_id', '=', $request->area_resp_id)->count();

        $response['recordsFiltered'] = $centros->count();

        $response['data'] = array_slice($centros->toArray(), $request->get('start'), $request->get('length'));
        return response()->json($response);
        //}
    }

}
