<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Staff;
use App\Models\Work;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Staff $staff, Bus $bus, Work $work, Income $income, Expense $expense)
    {
        $today = date('Y-m-d');
        $previousDate = date('Y-m-d', strtotime('-1 days'));
        $lastWeekDate = date('Y-m-d', strtotime('-7 days'));

        $data['staff'] = $staff->count();
        $data['bus'] = $bus->count();

        $data['income'] = $income->where('work_date', $today)->sum('amount');
        $data['expense'] = $expense->where('work_date', $today)->sum('amount');

        $data['prev_income'] = $income->where('work_date', $previousDate)->sum('amount');
        $data['prev_expense'] = $expense->where('work_date', $previousDate)->sum('amount');

        $data['last_week_income'] = $income->where('work_date', '>=', $lastWeekDate)->sum('amount');
        $data['last_week_expense'] = $expense->where('work_date', '>=', $lastWeekDate)->sum('amount');

        $data['last_month_income'] = $income->whereMonth('work_date', date('m'))->whereYear('work_date', date('Y'))->sum('amount');
        $data['last_month_expense'] = $expense->whereMonth('work_date', date('m'))->whereYear('work_date', date('Y'))->sum('amount');

        $busArr = $bus->get();
        foreach ($busArr as $bus){
            $bus->income = $work->where('bus_id', $bus->id)->sum('income');
            $bus->expense = $work->where('bus_id', $bus->id)->sum('expense');
            $bus->total = $bus->income - $bus->expense;
            $bus->silak = $bus->balance + $bus->total;
        }
        $data['buses'] = $busArr;

        return view('home', $data);
    }
}
