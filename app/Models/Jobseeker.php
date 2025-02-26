<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobseeker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id','survey_completed', 'birthday', 'gender', 'citizenship', 'phone', 'address', 'school', 
        'image', 'residentcard', 'jlpt', 'expected_to_graduate', 'parttimejob', 
        'wage', 'time', 'evaluation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluations()
    {
        return $this->hasMany(JobseekerEvaluation::class, 'jobseeker_id');
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'jobseeker_survey')
            ->withPivot('selected_option', 'score')
            ->withTimestamps();
    }

}
