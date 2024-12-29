<?php

namespace App\Models\material;

use App\Models\material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'caminho_arquivo'];

    public function material()
    {
        return $this->belongsTo(material::class);
    }
}
