<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseQuiz extends Model
{
    protected $fillable = ['quiz_id', 'user_id', 'template', 'score', 'is_finished'];

    protected $casts = [
        'template' => 'array',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
