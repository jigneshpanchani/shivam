<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index(){
        return view('settings.history');
    }
    public function remove(Request $request, Work $work)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'start_date'    => 'required',
                'end_date'      => 'required'
            ]);
            if($validator->fails()){
                return redirect()->route('history')->withErrors($validator)->withInput();
            }

            $start = Carbon::parse($request->start_date)->format('Y-m-d');
            $end = Carbon::parse($request->end_date)->format('Y-m-d');

            $res = Work::whereBetween('work_date',[$start, $end])->delete();

            if($res){
                $request->session()->flash('success', 'Work Report Delete successfully');
                return redirect()->route('history');
            }else{
                $err_msg = 'Oops...Something want wrong. Please try again.';
                return redirect()->route('history')->with('error', $err_msg)->withInput();
            }
        }catch(\Exception $e){
            return redirect()->route('history')->with('error', $e->getMessage())->withInput();
        }
    }

}
