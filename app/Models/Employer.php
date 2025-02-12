<?php

// In Employer.php (Eloquent Model)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

