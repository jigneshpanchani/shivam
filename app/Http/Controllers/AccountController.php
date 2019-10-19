<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Account_detail;
use App\Models\Bus;
use App\Models\Log;
use App\Models\Partner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    private $model;
    private $partner;
    private $bus;
    private $adetail;
    public function __construct(Account $account, Partner $partner, Bus $bus, Account_detail $adetail)
    {
        $this->model = $account;
        $this->partner = $partner;
        $this->bus = $bus;
        $this->adetail = $adetail;
    }

    public function index(){
        $data['accounts'] = $this->model->with('partner')->orderBy('id','DESC')->get();
        return view('account.index', $data);
    }

    public function create(){
        $data['partners'] = $this->partner->pluck('name', 'id');
        $data['buses'] = $this->bus->pluck('bus_number','id');
        return view('account.create', $data);
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'partner_id'    => 'required',
                'date'          => 'required',
                'add_bid'       => 'required|array',
                'add_amount'    => 'required|array',
                'wd_bid'        => 'required|array',
                'wd_amount'     => 'required|array'
            ]);
            if($validator->fails()){
                return redirect()->route('account.create')->withErrors($validator)->withInput();
            }
            $accountArr = $request->only('partner_id', 'date', 'note');
            if(!empty($request->date)){
                $accountArr['date'] = Carbon::parse($request->date)->format('Y-m-d');
            }
            $account_id = $this->model->create($accountArr)->id;

            $dataArr = $request->only('partner_id', 'date', 'add_bid', 'add_amount', 'add_detail', 'wd_bid', 'wd_amount', 'wd_detail');
            $res = $this->addWorkReport($account_id, $dataArr);

            if($res){
                $request->session()->flash('success', 'Work report add successfully');
                return redirect()->route('account.create');
            }else{
                $lastWork = $this->model->findOrFail($account_id);
                $lastWork->delete();
                $err_msg = 'Oops...Something want wrong. Please try again.';
                return redirect()->route('account.create')->with('error', $err_msg)->withInput();
            }
        }catch(\Exception $e){
            return redirect()->route('account.create')->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
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

    public function addWorkReport($account_id, $data){

        $addAmountTotal = $wdAmountTotal = 0;
        $date = date('Y-m-d', strtotime($data['date']));

        foreach ($data['add_amount'] as $add => $addAmount){
            if(!empty($addAmount)){
                $addAmountTotal = $addAmountTotal + $addAmount;
                $this->adetail->create([
                    'account_id'=> $account_id,
                    'bus_id'    => $data['add_bid'][$add],
                    'type'      => 'C',
                    'amount'    => $addAmount,
                    'detail'    => $data['add_detail'][$add],
                    'date'      => $date
                ]);
            }
        }

        foreach ($data['wd_amount'] as $wd => $wdAmount){
            if(!empty($wdAmount) && !empty($data['expense_id'][$wd])){
                $wdAmountTotal = $wdAmountTotal + $wdAmount;
                $this->adetail->create([
                    'account_id'=> $account_id,
                    'bus_id'    => $data['wd_bid'][$wd],
                    'type'      => 'D',
                    'amount'    => $wdAmountTotal,
                    'detail'    => $data['wd_detail'][$add],
                    'date'      => $date
                ]);
            }
        }

        if($addAmountTotal > 0 || $wdAmountTotal > 0){
            $workReport = $this->model->findOrFail($account_id);
            return $workReport->update(['credit'=>$addAmountTotal, 'debit'=>$wdAmountTotal]);
        }

        return FALSE;
    }

}
