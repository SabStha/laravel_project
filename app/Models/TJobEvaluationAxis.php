<?php
// app/Models/TJobEvaluationAxis.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class TJobEvaluationAxis extends Model
    {
        use HasFactory;

        protected $table = 't_job_evaluation_axes';

        protected $fillable = [
            'job_id',
            'evaluation_axis_id',
            'rating',
        ];

        public function evaluationAxis()
        {
            return $this->belongsTo(EvaluationAxis::class, 'evaluation_axis_id');
        }

        public function job()
        {
            return $this->belongsTo(Job::class, 'job_id');
        }
    }
