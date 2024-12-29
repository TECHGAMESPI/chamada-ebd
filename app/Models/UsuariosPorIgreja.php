<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuariosPorIgreja extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'igreja_id'];

    public function igreja()
    {
        return $this->hasOne(Igreja::class, 'id', 'igreja_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
