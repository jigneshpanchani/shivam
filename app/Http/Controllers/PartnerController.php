<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bus;
use App\Models\Partner;
use App\Models\Log;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    private $model;
    private $bus;
    public function __construct(Partner $partner, Bus $bus)
    {
        $this->model = $partner;
        $this->bus = $bus;
    }

    public function index()
    {
        $data['partners'] = $this->model->get();
        return view('partner.index', $data);
    }

    public function create()
    {
        $data['buses'] = $this->bus->pluck('bus_number','id');
        return view('partner.create', $data);
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'name'      => 'required',
                'contact_no'=> 'required',
                'bus'       => 'required|array'
            ]);
            if($validator->fails()){
                return redirect()->route('partner.create')->withErrors($validator)->withInput();
            }

            $inputArr = $request->only('name', 'contact_no', 'address', 'note');
            $partner = $this->model->create($inputArr);
            $partner->update(['bus_ids' => json_encode(array_keys($request->input('bus')))]);

            $request->session()->flash('success', 'New partner add successfully');
            return redirect()->route('partner.create');
        }catch(\Exception $e){
            return redirect()->route('partner.create')->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id, Account $account)
    {
        $result = $this->model->find($id);
        if($result){
            $data['result'] = $result;
            $data['deposits'] = $account->where('partner_id', $id)->where('credit','>',0)->get();
            $data['withdrawals'] = $account->where('partner_id', $id)->where('debit','>',0)->get();

            $data['deposit_total'] = $account->where('partner_id', $id)->sum('credit');
            $data['withdrawal_total'] = $account->where('partner_id', $id)->sum('debit');
//
//            $data['totalSal'] = $salary->where(['staff_id'=>$id, 'income_type'=>'S'])->sum('amount');
//            $data['totalWdl'] = $salary->where(['staff_id'=>$id, 'income_type'=>'W'])->sum('amount');
//            $data['total'] = ($data['totalSal'] - $data['totalWdl']) + ($result['balance']);
            return view('partner.show', $data);
        }else{
            return redirect()->route('partner.index');
        }
    }

    public function edit($id)
    {
        $result = $this->model->find($id);
        if($result){
            $data['buses'] = $this->bus->pluck('bus_number','id');
            $data['busArr'] = json_decode($result->bus_ids);
            $data['result'] = $result;
            return view('partner.edit', $data);
        }else{
            return redirect()->route('partner.index');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'name'      => 'required',
                'contact_no'=> 'required',
                'bus'       => 'required|Array'
            ]);
            if($validator->fails()){
                return redirect()->route('partner.edit', $id)->withErrors($validator)->withInput();
            }
            $updateArr = $request->only('name', 'contact_no', 'address', 'note');
            $partner = $this->model->findOrFail($id);
            $res = $partner->update($updateArr);
            $res1 = $partner->update(['bus_ids' => json_encode(array_keys($request->input('bus')))]);
            if($res && $res1){
                $request->session()->flash('success', 'Partner info update successfully');
            }else{
                $request->session()->flash('error', 'Something want wrong. Please try again.');
            }
            return redirect()->route('partner.edit', $id);
        }catch(\Exception $e){
            return redirect()->route('partner.edit', $id)->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id, Log $log)
    {
        try{
            $partner = $this->model->findOrFail($id);
            $res = $partner->delete($id);
            if($res){
                $log->addLog($partner, 'Delete', 'Partner detail remove');
                return response()->json(['title' => 'Deleted!', 'status' => 'success', 'msg' => 'Partner detail delete successfully.']);
            }else{
                return response()->json(['title' => 'Not Deleted!', 'status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

 }