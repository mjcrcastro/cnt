<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //Show list of Contacts
        return view('contact.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //Display new Contact Form
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }

        $cities = City::orderBy('description', 'asc')
                ->pluck('description', 'id');

        return view('contact.create', compact('cities'));
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

        $request->validate(Contact::$createRules);

        //if valid data, create a new country entry
        $contact = Contact::create($request->all());
        //and return to the index
        return redirect()->route('contacts.index')
                        ->with('message', 'Contacto ' . $contact->first_name . ' Registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact) {
        //Redirect to contact editor
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) { //I the user does not have permissions
            return redirect()->back()->with('message', $message);
        }

        if (is_null($contact)) { //if no shop is found
            return redirect()->route('contacts.index'); //go to previous page
        }
        $cities = City::orderBy('description', 'asc')
                ->pluck('description', 'id');
        //otherwise display the shop editor view
        return view('contact.edit', compact('contact', 'cities'));
        // End of actual code to execute
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact) {
        ///
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        //make sure the description is unique but 
        //exclude the $id for the current shop
        $request->validate(array(
            'first_name' => 'required',
        ));
        $contact->update($request->all());

        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact) {
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->with('message', $message);
        }
        $contact->delete();
        return redirect()->route('contacts.index');
    }

    public function contactsAjax(Request $request) {
        //returns list of countries
        $action_code = basename(__FILE__, '.php') . '_' . __FUNCTION__; //returns filename_function as a string
        $message = usercan($action_code, Auth::user());
        if ($message) {
            return redirect()->back()->withErrors('message', $message);
        }
        if ($request->ajax()) {//return json data only to ajax queries 
            $columnIndex = $request->order[0]['column'];
            $orderBy = $request->columns[$columnIndex]['data'];
            $filter = $request->search['value'];

            $contact = Contact::where(DB::raw('concat(COALESCE(`first_name`,""), " ", COALESCE(`last_name`,""))'), 'LIKE', "%" . $filter . "%")
                    ->orderBy($orderBy, $request->order[0]['dir'])
                    ->get();

            $response['draw'] = $request->get('draw');

            $response['recordsTotal'] = Contact::all()->count();

            $response['recordsFiltered'] = $contact->count();

            $response['data'] = array_slice($contact->toArray(), $request->get('start'), $request->get('length'));

            return response()->json($response);
        }
    }

}
