<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'operator_id', // Make sure this is correct
        'evaluator_name',
        'rating',
        'comment',
        'status',
    ];

    // Define the relationship with the operator (user)
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function evaluation()
    {
    return $this->hasOne(Evaluation::class, 'jobseeker_id');
    }
}
