<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'igreja_id', 'slug', 'is_draft', 'owner_id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function schedulings()
    {
        return $this->hasMany(Scheduling::class);
    }
}
