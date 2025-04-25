<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Jobseeker;
use App\Models\EvaluationAxis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\RegistersUsers;

class OperatorController extends Controller
{
    use RegistersUsers;

    // ... existing code ...
} 