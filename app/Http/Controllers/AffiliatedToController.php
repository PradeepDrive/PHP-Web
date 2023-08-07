<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliatedTo;
use Illuminate\Support\Facades\Validator;

class AffiliatedToController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affiliated = AffiliatedTo::all();
        return view('affiliatedto.index')->with([
            'menu' => 'affiliatedto',
            'affiliated' => $affiliated,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("affiliatedto.add")->with([
            "menu" => "affiliatedto"
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
            "Name" => "required|string",
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        AffiliatedTo::insert(['Name' => $request->Name]);
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
        $edit = AffiliatedTo::whereId($id)->first();
        return view('affiliatedto.edit')->with([
            'menu' => 'affiliatedto',
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
            "Name" => "required|string",
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        \DB::table('AffiliatedTo')->whereId($id)
        ->update(['Name' => $request->Name]);
        return redirect()->route("affiliated.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AffiliatedTo::Where('Id',$id)->delete();
        return redirect()->back();
    }
}
