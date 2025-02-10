<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerEvaluation extends Model
{
    use HasFactory;

    protected $fillable = ['jobseeker_id', 'evaluation_axis_id', 'rating'];

    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }

    public function evaluationAxis()
    {
        return $this->belongsTo(EvaluationAxis::class, 'evaluation_axis_id');
    }
}
