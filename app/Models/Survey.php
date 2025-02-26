<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    
    protected $fillable = ['question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'explanation_a', 'explanation_b', 'explanation_c', 'explanation_d'];

    public function jobseekers()
    {
        return $this->belongsToMany(Jobseeker::class, 'jobseeker_survey')
            ->withPivot('selected_option', 'score')
            ->withTimestamps();
    }
}
