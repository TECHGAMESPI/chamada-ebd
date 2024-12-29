<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduling extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'igreja_id',
        'quiz_id',
        'start_date',
        'end_date',
        'turma_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function igreja()
    {
        return $this->belongsTo(Igreja::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
