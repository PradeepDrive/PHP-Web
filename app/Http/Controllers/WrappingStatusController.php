<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderSummary;
use App\Models\WindowsAssembly;
use App\Models\WorkOrder;
use App\Models\Stock;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
            // $order_number = 102206;
            $data[$order_number]['frame_report'] = DB::table('framereport')->where('LINE #1', 'like', $order_number.'-%')->distinct('LINE #1')->count();
            $data[$order_number]['windows_assembly'] = WindowsAssembly::where('Line_number', 'like', $order_number.'-%')->distinct('Line_number')->count();
            $data[$order_number]['stock'] = Stock::where('item_number', 'like', $order_number.'-%')->distinct('item_number')->count();
            $data[$order_number]['work_order'] = WorkOrder::where('LINE #1', 'like', $order_number.'-%')->distinct('LINE #1')->count();


            $stockArray = Stock::where('item_number', 'like', $order_number.'-%')->distinct('item_number')->pluck('item_number');
            $workOrderArray = WorkOrder::where('LINE #1', 'like', $order_number.'-%')->distinct('LINE #1')->pluck('LINE #1');
            $unmatched = array_values($workOrderArray->diff($stockArray)->toArray());
            foreach ($unmatched as &$value) {
                $parts = explode('-', $value); // Split the string by '-'
                array_pop($parts); // Remove the last element
                $value = implode('-', $parts); // Join the parts back into a string
            }
            
            unset($value); 

            foreach ($unmatched as $value) {
            
                $frameReportData = DB::table('framereport')
                                    ->where('LINE #1', 'like', "%$value%")
                                    ->distinct('LINE #1')
                                    ->pluck('LINE #1');

                $windowsOrderData = WindowsAssembly::where('Line_number', 'like', "%$value%")
                                    ->whereYear('DATE', 2024)
                                    ->distinct('Line_number')
                                    ->pluck('Line_number');

                $matchedRecords = [];
                $unmatchedRecords = [];
                
                // Iterate over each record in $frameReportData
                foreach ($frameReportData as $record) {
                    // Check if the record is in $windowsOrderData
                    if ($windowsOrderData->contains($record)) {
                        // Matched record
                        $types = DB::table('framereport')
                            ->where('LINE #1', $record)
                            ->select(DB::raw('`W.TYPE` as W_TYPE'))
                            ->pluck('W_TYPE');
                
                        foreach ($types as $type) {
                            $matchedRecords[] = [
                                'LINE #1' => $record,
                                'W_TYPE' => $type,
                            ];
                        }
                    } else {
                        // Unmatched record
                        $types = DB::table('framereport')
                            ->where('LINE #1', $record)
                            ->select(DB::raw('`W.TYPE` as W_TYPE'))
                            ->pluck('W_TYPE');
                
                        foreach ($types as $type) {
                            $unmatchedRecords[] = [
                                'LINE #1' => $record,
                                'W_TYPE' => $type,
                            ];
                        }
                    }
                }
                
                // Append matched and unmatched records to existing arrays
                $data[$order_number]['pending_status']['matchedRecords'] = array_merge($data[$order_number]['pending_status']['matchedRecords'] ?? [], $matchedRecords);
                $data[$order_number]['pending_status']['unmatchedRecords'] = array_merge($data[$order_number]['pending_status']['unmatchedRecords'] ?? [], $unmatchedRecords);
                
            }

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

    public function waterTemperatureCreate(Request $request)
    {
        // $user = Auth::user()
        return view('wrapping_status.water_temperature_create')->with([
            "menu" => "water_temperature"
        ]);
    }


    public function waterTemperatureStore(Request $request)
    {
        $user = Auth::user();
        $request['name'] = $user->username;
        $request['date'] = Carbon::now()->format('Y-m-d');
        $request['time'] = Carbon::now()->format('H:i');
        $request['created_at'] =  Carbon::now()->format('Y-m-d H:i:s');
        $request['updated_at'] =  Carbon::now()->format('Y-m-d H:i:s');

        // Insert data into the database
        try {
            $saved = DB::table('water_temperature')->insert($request->except('_token'));
        } catch (\Exception $e) {
            // Log or dump the exception message
            dd($e->getMessage());
        }
        $request->session()->flash("info_message","Water Temperature has been added successfully.");
        
        return redirect()->back();
    }
}

