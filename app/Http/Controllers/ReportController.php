<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index(){
        $data['typeArr'] = array('E'=>'expense', 'I'=>'income', 'S'=>'salary', 'W'=>'work');
        return view('settings.report', $data);
    }
    public function generate(Request $request, Work $work)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'report_type'   => 'required',
                'start_date'    => 'required|date',
                'end_date'      => 'required|date|after:start_date'
            ]);
            if($validator->fails()){
                return redirect()->route('report')->withErrors($validator)->withInput();
            }
            $this->report($request->input());

        }catch(\Exception $e){
            return redirect()->route('history')->with('error', $e->getMessage())->withInput();
        }
    }

    private function report($data){
        //echo "<pre>";print_r($data);die;
        $start = Carbon::parse($data['start_date'])->format('Y-m-d');
        $end = Carbon::parse($data['end_date'])->format('Y-m-d');

        $workArr = Work::whereBetween('work_date',[$start, $end])->orderBy('work_date')->get();
        echo "<pre>";print_r($workArr);die;

    }

}
