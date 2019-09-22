<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    private $model;
    private $department;
    public function __construct(Staff $staff)
    {
        $this->model = $staff;
        $this->department = array('Driver', 'Conductor', 'CA', 'Metaji', 'Office-boy', 'Cleaner');
    }

    public function index()
    {
        $data['staff'] = $this->model->get();
        return view('staff.index', $data);
    }

    public function create()
    {
        $data['departments'] = $this->department;
        return view('staff.create', $data);
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'department'=> 'required',
                'name'      => 'required',
                'salary'    => 'required',
                'address'   => 'required'
            ]);
            if($validator->fails()){
                return redirect()->route('staff.create')->withErrors($validator)->withInput();
            }

            $inputArr = $request->only('department', 'name', 'contact_no', 'aadhar_card_no', 'salary', 'address', 'note');
            $this->model->create($inputArr);
            $request->session()->flash('success', 'New member add successfully');
            return redirect()->route('staff.create');
        }catch(\Exception $e){
            return redirect()->route('staff.create')->with('error', $e->getMessage())->withInput();
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
            $data['departments'] = $this->department;
            return view('staff.edit', $data);
        }else{
            return redirect()->route('staff.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'department'=> 'required',
                'name'      => 'required',
                'salary'    => 'required',
                'address'   => 'required'
            ]);
            if($validator->fails()){
                return redirect()->route('staff.edit', $id)->withErrors($validator)->withInput();
            }
            $updateArr = $request->only('department', 'name', 'contact_no', 'aadhar_card_no', 'salary', 'address', 'note');
            $staff = $this->model->findOrFail($id);
            $res = $staff->update($updateArr);
            if($res){
                $request->session()->flash('success', 'Staff info update successfully');
            }else{
                $request->session()->flash('error', 'Something want wrong. Please try again.');
            }
            return redirect()->route('staff.edit', $id);
        }catch(\Exception $e){
            return redirect()->route('staff.edit', $id)->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try{
            $staff = $this->model->findOrFail($id);
            $res = $staff->delete($id);
            if($res){
                return response()->json(['title' => 'Deleted!', 'status' => 'success', 'msg' => 'Staff detail delete successfully.']);
            }else{
                return response()->json(['title' => 'Not Deleted!', 'status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function detail($id){

        print_r($id);die;
        $res = $this->model->find($id);
        if($res){
            return response()->json(['status' => 'success', 'data' => $res]);
        }else{
            return response()->json(['status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
        }
    }
}
