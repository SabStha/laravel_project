<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['employer_id', 'title', 'description', 'job_type', 'working_days', 'working_hours', 'location', 'salary', 'required_skills', 'visa_required', 'image'];


    protected $casts = [
        'working_days' => 'array',  // Automatically casts working_days as an array
    ];

    
    protected $dates = ['deleted_at', 'posted_at', 'expires_at'];


    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
