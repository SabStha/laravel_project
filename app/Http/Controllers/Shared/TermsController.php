<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

class TermsController extends Controller
{
    public function index()
    {
        return view('shared.terms');
    }
} 