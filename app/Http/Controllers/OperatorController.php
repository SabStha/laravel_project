<?php

namespace App\Http\Controllers; // Make sure this is correct

use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('operator');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
