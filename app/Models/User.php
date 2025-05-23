<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Jobseeker;
use App\Models\Employer;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isJobseeker()
    {
        return $this->user_type === 'jobseeker';
    }

    public function isEmployer()
    {
        return $this->user_type === 'employer';
    }

    public function isOperator()
    {
        return $this->user_type === 'operator';
    }


    public function jobseeker(): HasOne
    {
        return $this->hasOne(Jobseeker::class);
    }

    public function employer(): HasOne
    {
        return $this->hasOne(Employer::class);
    }
    
}
