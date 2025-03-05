<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function showCompanyInfo()
{
    return view('about');
}
}
