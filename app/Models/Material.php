<?php

namespace App\Models;

use App\Models\material\{Arquivo, LinkExterno, Texto, YouTube};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class material extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'publicar_em', 'user_id', 'igreja_id', 'material_global'];

    public function arquivos()
    {
        return $this->hasMany(Arquivo::class);
    }

    public function you_tubes()
    {
        return $this->hasMany(YouTube::class);
    }

    public function links_externos()
    {
        return $this->hasMany(LinkExterno::class);
    }

    public function textos()
    {
        return $this->hasMany(Texto::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->orderBy('id', 'desc');
    }

    public function igreja()
    {
        return $this->belongsTo(Igreja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
