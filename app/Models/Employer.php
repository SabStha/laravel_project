<?php

// In Employer.php (Eloquent Model)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

<<<<<<< HEAD
    // Add user_id to the fillable property
    protected $fillable = [
        'user_id',
        // Add other necessary fields for employer here, such as company name, etc.
    ];
=======
    protected $fillable = ['name', 'email', 'password'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
>>>>>>> 0302e1f94658b32a941265da47d40f5873256a35
}

