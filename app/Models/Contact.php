<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'message', 'status', 'user_id'];

    // Взаимосвязь с пользователем
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
