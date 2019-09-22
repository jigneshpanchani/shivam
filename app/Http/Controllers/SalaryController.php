<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Salary;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class SalaryController extends Controller
{
    private $model;
    public function __construct(Salary $salary)
    {
        $this->model = $salary;
    }

    public function index()
    {
        $data['salaries'] = $this->model->with('staff')->orderBy('id','DESC')->get();
        return view('salary.index', $data);
    }

    public function create(Staff $staff)
    {
        $data['staff'] = $staff->get();
        return view('salary.create', $data);
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'staff_id'  => 'required|array',
                'salary'    => 'required|array'
            ]);
            if($validator->fails()){
                return redirect()->route('salary.create')->withErrors($validator)->withInput();
            }
            $inputArr = $request->only('date', 'staff_id', 'salary');
            $res = $this->addSalary($inputArr);
            if($res){
                $request->session()->flash('success', 'Salary add successfully');
                return redirect()->route('salary.create');
            }else{
                $err_msg = 'Oops...Something want wrong. Please try again.';
                return redirect()->route('salary.create')->with('error', $err_msg)->withInput();
            }
        }catch(\Exception $e){
            return redirect()->route('salary.create')->with('error', $e->getMessage())->withInput();
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
            return view('salary.edit', $data);
        }else{
            return redirect()->route('salary.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'date'      => 'required',
                'amount'    => 'required'
            ]);
            if($validator->fails()){
                return redirect()->route('salary.edit', $id)->withErrors($validator)->withInput();
            }
            $updateArr = $request->only('date', 'amount');
            if(!empty($request->date)){
                $updateArr['date'] = Carbon::parse($request->date)->format('Y-m-d');
            }
            $salary = $this->model->findOrFail($id);
            $res = $salary->update($updateArr);
            if($res){
                $request->session()->flash('success', 'Salary info update successfully');
            }else{
                $request->session()->flash('error', 'Something want wrong. Please try again.');
            }
            return redirect()->route('salary.edit', $id);
        }catch(\Exception $e){
            return redirect()->route('salary.edit', $id)->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id, Log $log)
    {
        try{
            $salary = $this->model->findOrFail($id);
            $res = $salary->delete($id);
            if($res){
                $log->addLog($salary, 'Delete', 'Salary delete');
                return response()->json(['title' => 'Deleted!', 'status' => 'success', 'msg' => 'Salary detail delete successfully.']);
            }else{
                return response()->json(['title' => 'Not Deleted!', 'status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function addSalary($data){
        $date = date('Y-m-d', strtotime($data['date']));
        $userID = Auth::user()->id;
        $dataSet = array();
        foreach ($data['staff_id'] as $k =>$staff_id){
            $dataSet[] = ['staff_id'=>$staff_id, 'amount'=>$data['salary'][$k], 'date'=>$date, 'created_by'=>$userID];
        }
        return DB::table('salaries')->insert($dataSet);
    }
}
