<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextAPI;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Arr;

class TextAPIController extends Controller
{
    public function textAPIForm(Request $request)
    {
        $text_api = TextAPI::first();
        return view('textapi.form')->with([
            'menu' => 'text_api',
            'sms' => $text_api,
        ]);
    }

    public function textAPIStore(Request $request)
    {
        $rule = [
            "text_url" => "required",
            "token" => "required",
            "from" => "required",
            "message" => "required",
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails())
            return back()->withErrors($validator)->withInput()->with('error_message', $validator->errors()->first());
        TextAPI::truncate();
        TextAPI::insert(Arr::except($request->all(), '_token'));
        $request->session()->flash("info_message", "Data has been saved successfully.");
        return redirect()->back();
    }

    public function textAPIDestory(Request $request)
    {
        TextAPI::truncate();
        $request->session()->flash("info_message", "Data has been removed successfully.");
        return redirect()->back();
    }
}
