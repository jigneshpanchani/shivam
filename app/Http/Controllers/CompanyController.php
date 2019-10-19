<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    private $model;
    private $bus;
    public function __construct(Company $company, Bus $bus)
    {
        $this->model = $company;
        $this->bus = $bus;
    }

    public function index()
    {
        return view('welcome');
    }

    public function create()
    {
        $data['departments'] = $this->bus->get();
        return view('company.create', $data);
    }

    public function store(Request $request)
    {
        //
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

    public function destroy($id)
    {
        //
    }
}
