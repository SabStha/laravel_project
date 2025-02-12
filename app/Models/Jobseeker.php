<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobseeker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'evaluation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluations()
    {
        return $this->hasMany(JobseekerEvaluation::class, 'jobseeker_id');
    }
}
