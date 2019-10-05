<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Log;
use Illuminate\Http\Request;

class BusController extends Controller
{
    private $model;
    public function __construct(Bus $bus)
    {
        $this->model = $bus;
    }

    public function index()
    {
        $data['buses'] = $this->model->get();
        return view('bus.index', $data);
    }

    public function create()
    {
        return view('bus.create');
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'bus_number'    => 'required|unique:buses,bus_number',
                'balance'       => 'required',
                'type'          => 'required',
                'owner_name'    => 'required',
                'root'          => 'required'
            ]);
            if($validator->fails()){
                return redirect()->route('bus.create')->withErrors($validator)->withInput();
            }

            $inputArr = $request->only('bus_number', 'balance', 'owner_name', 'root', 'type', 'seat', 'fuel_capacity', 'note');
            $this->model->create($inputArr);
            $request->session()->flash('success', 'New bus add successfully');
            return redirect()->route('bus.create');
        }catch(\Exception $e){
            return redirect()->route('bus.create')->with('error', $e->getMessage())->withInput();
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
            return view('bus.edit', $data);
        }else{
            return redirect()->route('bus.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'bus_number'    => 'required|unique:buses,bus_number,'.$id,
                'balance'       => 'required',
                'owner_name'    => 'required',
                'type'          => 'required',
                'root'          => 'required'
            ]);
            if($validator->fails()){
                return redirect()->route('bus.edit', $id)->withErrors($validator)->withInput();
            }
            $updateArr = $request->only('bus_number', 'balance', 'owner_name', 'root', 'type', 'seat', 'fuel_capacity', 'note');
            $bus = $this->model->findOrFail($id);
            $res = $bus->update($updateArr);
            if($res){
                $request->session()->flash('success', 'Bus info update successfully');
            }else{
                $request->session()->flash('error', 'Something want wrong. Please try again.');
            }
            return redirect()->route('bus.edit', $id);
        }catch(\Exception $e){
            return redirect()->route('bus.edit', $id)->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id, Log $log)
    {
        try{
            $bus = $this->model->findOrFail($id);
            $res = $bus->delete($id);
            if($res){
                $log->addLog($bus, 'Delete', 'Bus delete');
                return response()->json(['title' => 'Deleted!', 'status' => 'success', 'msg' => 'Bus detail delete successfully.']);
            }else{
                return response()->json(['title' => 'Not Deleted!', 'status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

}
