<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $employee;
    private $department;
    public function __construct()
    {

    }

    public function index()
    {
        $data['employee'] = 10;
        $data['department'] = 14;
        $data['zone'] = 16;
        return view('dashboard', $data);
    }
}
