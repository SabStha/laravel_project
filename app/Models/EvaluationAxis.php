<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EvaluationAxis extends Model
{
    use HasFactory;

    protected $table = 'm_evaluation_axes';
    protected $fillable = ['code', 'name'];

    public function jobseekerEvaluations()
    {
        return $this->hasMany(JobseekerEvaluation::class, 'evaluation_axis_id');
    }
}
