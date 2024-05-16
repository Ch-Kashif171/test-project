<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Http\Requests\DropDownRequest;
use App\Models\DropDown;
use App\Models\DropDownOption;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'drop_downs' => DropDown::select('id', 'name')->get(),
            'options' => DropDownOption::select('id', 'option')->get(),
        ]);
    }

    public function getOptions(Request $request)
    {
        $options = DropDownOption::where('drop_down_id', $request->drop_down)->get(['id', 'option']);

        return response()->json(['options' => $options]);
    }

    public function store(DropDownRequest $request)
    {
        try {

            $dropDown = DropDown::where('id', $request->name)->value('name') ?? '';
            $dropDownOptions = DropDownOption::whereIn('id', $request->options)->get(['option']);

            return response()->json([
                'dropDown' => $dropDown,
                'dropDownOptions' => $dropDownOptions,
            ]);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
}
