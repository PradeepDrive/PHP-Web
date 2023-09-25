<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contacts::all();
        return view('contacts.index')->with([
            'menu' => 'contacts',
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("contacts.add")->with([
            "menu" => "contacts"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            "name" => "required|string",
            "phone_number" => "required",
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        Contacts::insert(['name' => $request->name, 'phone_number' => $request->phone_number]);
        $request->session()->flash("info_message", "Data has been saved successfully.");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Contacts::whereId($id)->first();
        return view('contacts.edit')->with([
            'menu' => 'contacts',
            'edit' => $edit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rule = [
            "name" => "required|string",
            "phone_number" => "required",
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        \DB::table('contacts')->whereId($id)
        ->update(['name' => $request->name, 'phone_number' => $request->phone_number]);
        return redirect()->route("contacts.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contacts::Where('id',$id)->delete();
        return redirect()->back();
    }
}
