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
        //Display new AreaResp Form
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        return view('arearesp.create');
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

        $request->validate(AreaResp::$createRules);

        //if valid data, create a new Area de Responsabilidad
        $area_resp = AreaResp::create($request->all());
        //and return to the index
        return redirect()->route('arearesp.index')
                        ->with('message', 'Area ' . $area_resp->description . ' Registrada');
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
    public function edit(AreaResp $arearesp) {
        //Redirect to arearesp editor
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) { //I the user does not have permissions
            return redirect()->back()->with('message', $message);
        }

        if (is_null($arearesp)) { //if no shop is found
            return redirect()->route('arearesp.index'); //go to previous page
        }

        //otherwise display the shop editor view
        return view('arearesp.edit', compact('arearesp'));
        // End of actual code to execute
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        //make sure the description is unique but 
        //exclude the $id for the current shop
        $request->validate(['description' => 'required|unique:area_resps,description,' . $id . 'id']);

        $arearesp = AreaResp::find($id);
        $arearesp->update($request->all());
        return redirect()->route('arearesp.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaResp  $areaResp
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        $noDeleteMsg = 'Borrado no permitido, reutilice el código '.sprintf("%02d", $id);
        return redirect()->back()->with('message', $noDeleteMsg);
        //AreaResp::find($id)->delete();
        //return redirect()->route('arearesp.index');
    }

    public function arearespAjax(Request $request) {

        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->withErrors('message', $message);
        }
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
