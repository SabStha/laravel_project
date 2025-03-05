<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobseekerSurvey extends Model
{
    use HasFactory;

    protected $table = 'jobseeker_survey'; // Explicitly define table name

    protected $fillable = ['jobseeker_id', 'survey_id', 'selected_option', 'score'];

    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
