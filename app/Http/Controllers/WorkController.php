<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    private $model;
    public function __construct(Staff $staff)
    {
        $this->model = $staff;
    }

    public function index(){
        $data['staff'] = $this->model->get();
        return view('work.daily-report', $data);
    }
}
