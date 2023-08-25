<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class CwInventoryController extends Controller
{

    /**
     * To create a new complete window inventory
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("complete_windows_inventory.add")->with([
            "menu" => "cwi"
        ]);
    }

    /**
     * To store value in wrapped windows
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            "location" => "required|string",
            "batch_number" => "required|string",
            "referance" => "required|string",
            "id_number" => "required|string|unique:wrapped_windows,LINE#,NULL,id",
            "name" => "required|string",
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        $work_order = (array) DB::table('workorder')->select('ORDER #', 'PO', 'DEALER')->where('LINE #1', $request->id_number)->first();
        if(@!$work_order) {
            return back()->withInput()->with('error_message', 'Id number not exist');
        }
        $data['Location'] = $request->location;
        $data['BatchNumber'] = $request->batch_number;
        $data['Reference'] = $request->referance;
        $data['Name'] = $request->name;
        $data['LINE#'] = $request->id_number;
        $data['Date'] = date('Y-m-d');
        $data['Time'] = date('H:i:s');
        
        $data['CompanyName'] = $work_order['DEALER'];
        $data['CustomerName'] = $work_order['PO'];
        $data['OrderNumber'] = $work_order['ORDER #'];
        DB::table('wrapped_windows')->insert($data);
        $request->session()->flash("info_message", "Data has been saved successfully.");
        session(['data' => $request->all()]);
        return redirect()->back()->withInput();
    }

    /**
     * To search value in workoder table
     *
     * @return \Illuminate\Http\Response
     */
    public function idSearchWithMap(Request $request)
    {
        $search_val = $request->search_value;
        if (isset($search_val) && $search_val != '') {
            $workorder = DB::table('workorder')->select('LINE #1')->orderBy('LINE #1', 'asc');
            $workorder->where(function ($query) use ($search_val) {
                $query->orwhere('LINE #1', 'LIKE', '%' . $search_val . '%');
            });
            $data = $workorder->limit('15')->get();
            return response()->json($data);
        }
    }
    
}
