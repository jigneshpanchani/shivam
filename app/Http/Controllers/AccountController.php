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
        //$data['buses'] = $this->bus->pluck('bus_number','id');
        return view('account.create', $data);
    }

    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'partner_id'=> 'required',
                'date'      => 'required',
                'bid'       => 'required|array',
                'amount'    => 'required|array'
            ]);
            if($validator->fails()){
                return redirect()->route('account.create')->withErrors($validator)->withInput();
            }
            $accountArr = $request->only('partner_id', 'date', 'note');
            if(!empty($request->date)){
                $accountArr['date'] = Carbon::parse($request->date)->format('Y-m-d');
            }
            $account_id = $this->model->create($accountArr)->id;

            $dataArr = $request->only('partner_id', 'date', 'amount_type', 'bid', 'amount', 'detail');
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
            $account = $this->model->findOrFail($id);
            $res = $account->delete($id);
            if($res){
                $log->addLog($account, 'Delete', 'Account report delete');
                return response()->json(['title' => 'Deleted!', 'status' => 'success', 'msg' => 'Account report delete successfully.']);
            }else{
                return response()->json(['title' => 'Not Deleted!', 'status' => 'error', 'msg' => 'Oops...Something want wrong. Please try again.']);
            }
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function addWorkReport($account_id, $data){

        $amountTotal = 0;
        $date = date('Y-m-d', strtotime($data['date']));

        foreach ($data['amount'] as $key => $amount){
            if(!empty($amount)){
                $amountTotal = $amountTotal + $amount;
                $this->adetail->create([
                    'account_id'=> $account_id,
                    'bus_id'    => $data['bid'][$key],
                    'type'      => $data['amount_type'],
                    'amount'    => $amount,
                    'detail'    => $data['detail'][$key],
                    'date'      => $date
                ]);
            }
        }

        if($amountTotal > 0){
            $accountReport = $this->model->findOrFail($account_id);
            $field = ($data['amount_type'] == 'C')?'credit':'debit';
            return $accountReport->update([$field=>$amountTotal]);
        }

        return FALSE;
    }

    public function getBusList(Request $request, Partner $partner, Bus $bus){

        $partnerID = $request->post('partnerId');
        $busIdArr = $partner->find($partnerID)->bus_ids;
        $buses = $bus->whereIn('id', json_decode($busIdArr))->pluck('bus_number','id');
        foreach ($buses as $id=>$number){
            $buses[$id] = trim(str_replace(' - ', ' ', substr($number, -9)));
        }
        return response()->json(['status' => 'success', 'buses' => $buses]);
    }
}
