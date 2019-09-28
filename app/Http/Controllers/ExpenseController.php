<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\Log;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private $model;
    public function __construct(ExpenseType $expenseType)
    {
        $this->model = $expenseType;
    }

    public function index()
    {
        $data['expenses'] = $this->model->get();
        return view('expense.index', $data);
    }

    public function create()
    {
        return view('expense.create');
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),['name' => 'required']);
            if($validator->fails()){
                return redirect()->route('expense.create')->withErrors($validator)->withInput();
            }

            $inputArr = $request->only('name', 'note');
            $this->model->create($inputArr);
            $request->session()->flash('success', 'New expense add successfully');
            return redirect()->route('expense.create');
        }catch(\Exception $e){
            return redirect()->route('expense.create')->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result = $this->model->find($id);
        if($result){
            $data['result'] = $result;
            return view('expense.edit', $data);
        }else{
            return redirect()->route('expense.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = \Validator::make($request->all(),['name' => 'required']);
            if($validator->fails()){
                return redirect()->route('expense.edit', $id)->withErrors($validator)->withInput();
            }
            $updateArr = $request->only('name', 'note');
            $expense = $this->model->findOrFail($id);
            $res = $expense->update($updateArr);
            if($res){
                $request->session()->flash('success', 'Expense info update successfully');
            }else{
                $request->session()->flash('error', 'Something want wrong. Please try again.');
            }
            return redirect()->route('expense.edit', $id);
        }catch(\Exception $e){
            return redirect()->route('expense.edit', $id)->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id, Log $log)
    {
        try{
            $expense = $this->model->findOrFail($id);
            $res = $expense->delete($id);
            if($res){
                $log->addLog($expense, 'Delete', 'Expense detail remove');
                return response()->json(['title' => 'Deleted!', 'status' => 'success', 'msg' => 'Expense detail delete successfully.']);
            }else{
                return response()->json(['title' => 'Not Deleted!', 'status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

 }