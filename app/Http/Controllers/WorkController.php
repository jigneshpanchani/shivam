<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Income;
use App\Models\Log;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{

    private $model;
    private $bus;
    private $expenseType;
    private $income;
    private $expense;
    public function __construct(Work $work, Bus $bus, ExpenseType $expenseType, Income $income, Expense $expense)
    {
        $this->model = $work;
        $this->bus = $bus;
        $this->expenseType = $expenseType;
        $this->income = $income;
        $this->expense = $expense;
    }

    public function index(){
        $data['works'] = $this->model->with('bus')->orderBy('id','DESC')->get();
        return view('work.index', $data);
    }

    public function create(){
        $data['buses'] = $this->bus->get();
        $data['expenseTypes'] = $this->expenseType->get();
        return view('work.create', $data);
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'bus_id'            => 'required',
                'work_date'         => 'required',
                'income_amount'     => 'required|array',
                'expense_id'        => 'required|array',
                'expense_amount'    => 'required|array'
            ]);
            if($validator->fails()){
                return redirect()->route('work.create')->withErrors($validator)->withInput();
            }
            $workArr = $request->only('bus_id', 'work_date', 'note');
            $workArr['created_by'] = Auth::user()->id;
            if(!empty($request->work_date)){
                $workArr['work_date'] = Carbon::parse($request->work_date)->format('Y-m-d');
            }
            $work_id = $this->model->create($workArr)->id;

            $dataArr = $request->only('bus_id', 'work_date', 'income_amount', 'income_detail', 'expense_id', 'expense_amount', 'expense_detail');
            $res = $this->addWorkReport($work_id, $dataArr);

            if($res){
                $request->session()->flash('success', 'Work report add successfully');
                return redirect()->route('work.create');
            }else{
                $lastWork = $this->model->findOrFail($work_id);
                $lastWork->delete();
                $err_msg = 'Oops...Something want wrong. Please try again.';
                return redirect()->route('work.create')->with('error', $err_msg)->withInput();
            }
        }catch(\Exception $e){
            return redirect()->route('work.create')->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $result = $this->model->with(['incomes', 'expenses'])->find($id);
        if($result){
            $data['expenseArr'] = $this->expenseType->pluck('name','id');
            $data['busArr'] = $this->bus->pluck('bus_number','id');
            $data['result'] = $result;
            return view('work.show', $data);
        }else{
            return redirect()->route('work.index');
        }
    }

    public function edit($id)
    {
        $result = $this->model->with(['incomes', 'expenses'])->find($id);
        if($result){
            $data['expenseTypes'] = $this->expenseType->get();
            $data['buses'] = $this->bus->get();
            $data['result'] = $result;
            return view('work.edit', $data);
        }else{
            return redirect()->route('work.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'bus_id'            => 'required',
                'work_date'         => 'required',
                'income_amount'     => 'required|array',
                'expense_id'        => 'required|array',
                'expense_amount'    => 'required|array'
            ]);
            if($validator->fails()){
                return redirect()->route('work.edit', $id)->withErrors($validator)->withInput();
            }
            $workArr = $request->only('bus_id', 'work_date', 'note');
            $workArr['created_by'] = Auth::user()->id;
            if(!empty($request->work_date)){
                $workArr['work_date'] = Carbon::parse($request->work_date)->format('Y-m-d');
            }
            $work = $this->model->findOrFail($id);
            $work->update($workArr);

            $dataArr = $request->only('bus_id', 'work_date', 'income_amount', 'income_detail', 'expense_id', 'expense_amount', 'expense_detail');
            $res = $this->updateWorkReport($id, $dataArr);

            if($res){
                $request->session()->flash('success', 'Work report update successfully');
                return redirect()->route('work.edit', $id);
            }else{
                $err_msg = 'Oops...Something want wrong. Please try again.';
                return redirect()->route('work.edit', $id)->with('error', $err_msg)->withInput();
            }
        }catch(\Exception $e){
            return redirect()->route('work.edit', $id)->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id, Log $log)
    {
        try{
            $work = $this->model->findOrFail($id);
            $res = $work->delete($id);
            if($res){
                $log->addLog($work, 'Delete', 'Work delete');
                return response()->json(['title' => 'Deleted!', 'status' => 'success', 'msg' => 'Work report delete successfully.']);
            }else{
                return response()->json(['title' => 'Not Deleted!', 'status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function addWorkReport($work_id, $data){

        $incomeTotal = $expenseTotal = 0;
        $work_date = date('Y-m-d', strtotime($data['work_date']));

        foreach ($data['income_amount'] as $inc => $income){
            if(!empty($income)){
                $incomeTotal = $incomeTotal + $income;
                $this->income->create([
                    'work_id'   => $work_id,
                    'amount'    => $income,
                    'detail'    => $data['income_detail'][$inc],
                    'work_date' => $work_date
                ]);
            }
        }

        foreach ($data['expense_amount'] as $exp => $expense){
            if(!empty($expense) && !empty($data['expense_id'][$exp])){
                $expenseTotal = $expenseTotal + $expense;
                $this->expense->create([
                    'work_id'   => $work_id,
                    'expense_id'=> $data['expense_id'][$exp],
                    'amount'    => $expense,
                    'detail'    => $data['expense_detail'][$exp],
                    'work_date' => $work_date
                ]);
            }
        }

        if($incomeTotal > 0 || $expenseTotal > 0){
            $workReport = $this->model->findOrFail($work_id);
            return $workReport->update(['income'=>$incomeTotal, 'expense'=>$expenseTotal]);
        }

        return FALSE;
    }

    public function updateWorkReport($work_id, $data){

        $this->income->where('work_id', $work_id)->delete();
        $this->expense->where('work_id', $work_id)->delete();
        return $this->addWorkReport($work_id, $data);
    }
}
