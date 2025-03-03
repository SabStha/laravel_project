<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['jobseeker_id', 'employer_id'];

    // ✅ Correct the relationship with messages
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function jobseeker()
    {
        return $this->belongsTo(User::class, 'jobseeker_id');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
