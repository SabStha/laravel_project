<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    // Add user_id to the fillable property
    protected $fillable = [
        'user_id',
        // Add other necessary fields for employer here, such as company name, etc.
    ];
}
