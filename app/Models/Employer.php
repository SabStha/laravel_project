<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_address',
        'company_phone',
        'status',
        'company_description',
        'website'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the user that owns the employer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job listings for the employer.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
