<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Income;
use App\Models\Salary;
use App\Models\Staff;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    private $expenseType;
    private $staff;
    private $work;
    private $bus;
    private $income;
    private $expense;
    private $salary;
    public function __construct(ExpenseType $expenseType, Staff $staff, Work $work, Bus $bus, Income $income, Expense $expense, Salary $salary)
    {
        $this->expenseType = $expenseType;
        $this->staff = $staff;
        $this->work = $work;
        $this->bus = $bus;
        $this->income = $income;
        $this->expense = $expense;
        $this->salary = $salary;
    }

    public function index(){
        $data['typeArr'] = array('E'=>'expense', 'I'=>'income', 'S'=>'salary', 'W'=>'work');
        $data['expenseArr'] = $this->expenseType->pluck('name','id');
        $data['staffArr'] = $this->staff->pluck('name','id');
        $data['busArr'] = $this->bus->pluck('bus_number','id');
        return view('settings.report-form', $data);
    }

    public function generate(Request $request)
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
            $res = $this->report($request->input());
            return view('settings.report', $res);
        }catch(\Exception $e){
            return redirect()->route('report')->with('error', $e->getMessage())->withInput();
        }
    }

    private function report($data){

        $type = $data['report_type'];
        $start = Carbon::parse($data['start_date'])->format('Y-m-d');
        $end = Carbon::parse($data['end_date'])->format('Y-m-d');
        $bId = $data['bus_id'];
        $sId = $data['staff_id'];
        $eId = $data['expense_id'];

        $title = "Report for ";
        $bName = ($bId != 'all') ? (str_replace(' ','', $this->bus->find($bId)->bus_number)) : '';
        $eName = ($eId != 'all') ? ($this->expenseType->find($eId)->name) : '';
        $sName = ($sId != 'all') ? ($this->staff->find($sId)->name) : '';

        if($type == 'E'){

            $query = $this->work->with('bus');
            if($bId == 'all'){
                if($eId == 'all'){
                    $query->with('expenses');
                    $title .= "all buses with all type of expenses";
                }else{
                    $query->whereHas('expenses', function($qq) use($eId){ $qq->where('expense_id', $eId); });
                    $title .= "all buses with expense ($eName)";
                }
            }else{
                if($eId == 'all'){
                    $query->with('expenses')->where('bus_id', $bId);
                    $title .= "bus ($bName) with all type of expenses";
                }else{
                    $query->whereHas('expenses', function($qq) use($eId){
                            $qq->where('expense_id', $eId);
                        })->where('bus_id', $bId);
                    $title .= "bus ($bName) with expense ($eName)";
                }

            }

            $data['expenses'] = $query->whereBetween('work_date', [$start, $end])->orderBy('work_date')->get();
            $data['expenseArr'] = $this->expenseType->pluck('name','id');
            $data['expId'] = $eId;

        }elseif($type == 'I'){

            $iQuery = $this->work->with('bus')->whereBetween('work_date',[$start, $end]);
            if($bId == 'all') {
                $title .= "all buses's Income";
            }else{
                $iQuery->where('bus_id', $bId);
                $title .= "bus ($bName)'s Income";
            }

            $data['incomes'] = $iQuery->orderBy('work_date')->get();

        }elseif($type == 'S'){

            $sQuery = $this->salary->with('staff')->whereBetween('date',[$start, $end]);
            if($sId == 'all'){
                $title .= "all staff members's salary/withdrawal";
            }else{
                $sQuery->where('staff_id', $sId);
                $title .= "staff ($sName)'s salary/withdrawal";
            }
            $data['salaries'] = $sQuery->orderBy('date')->get();

        }elseif($type == 'W'){

            $wQuery = $this->work->whereBetween('work_date',[$start, $end]);
            if($bId == 'all'){
                $title .= "all buses";
            }else{
                $data['works'] = $wQuery->where('bus_id', $bId);
                $title .= "bus ($bName)";
            }
            $data['works'] = $wQuery->orderBy('work_date')->get();

        }else{
            $data = array();
        }

        $title .= ' ['.$data['start_date'].' To '.$data['end_date']. ']';
        $data['title'] = $title;
        $data['type'] = $type;

        return $data;
    }

}
