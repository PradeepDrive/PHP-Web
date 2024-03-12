<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderSummary;
use App\Models\WindowsAssembly;
use App\Models\WorkOrder;
use App\Models\Stock;
use DB;

class WrappingStatusController extends Controller
{
    
    public function index()
    {
        return view('wrapping_status.index')->with([
            "menu" => "wrapping_status"
        ]);
    }


    public function wrappingStatusData(Request $request)
    {

        $date_with_format = date('Ymd', strtotime($request->date));
        $data = array();
        $order_summaries = OrderSummary::select('ORDER#')->where('LIST DATE', $date_with_format)->pluck('ORDER#')->toArray();
        
        foreach ($order_summaries as $order_number) {
            $data[$order_number]['frame_report'] = DB::table('framereport')->where('LINE #1', 'like', $order_number.'-%')->count();  
            $data[$order_number]['windows_assembly'] = WindowsAssembly::where('Line_number', 'like', $order_number.'-%')->count();  

            $work_order = WorkOrder::where('ORDER #', $order_number)->select('LINE #1', 'ORDER #');
            $stock = Stock::whereIn('item_number', $work_order->pluck('LINE #1')->toArray())->select('item_number');
            $data[$order_number]['status'] = ($work_order->count() == $stock->count()) ? 'Completed' : 'Pending';
        }

        return $data;
    }


    public function temperatureCreate(Request $request)
    {
        return view('wrapping_status.temperature_create')->with([
            "menu" => "temperature"
        ]);
    }


    public function temperatureStore(Request $request)
    {
        DB::table('Temperature')->insert($request->except('_token'));
        $request->session()->flash("info_message","Temperature has been added successfully.");
        return redirect()->back();
    }
}
