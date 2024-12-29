<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacaomaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'muito_ruim',
        'ruim',
        'razoavel',
        'muito_bom',
        'excelente',
        'user_id',
        'material_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(material::class);
    }

    public function muitoRuim($id)
    {
        //return new Attribute(fn () => $this->material()->where('muito_ruim', true)->count());
        return $this->where(['material_id' => $id, 'muito_ruim' => true])->count();
    }

    public function ruim($id)
    {
        // return new Attribute(fn () => $this->material()->sum('ruim'));
        return $this->where(['material_id' => $id, 'ruim' => true])->count();
    }

    public function razoavel($id)
    {
        // return new Attribute(fn () => $this->material()->sum('razoavel'));
        return $this->where(['material_id' => $id, 'razoavel' => true])->count();
    }

    public function muitoBom($id)
    {
        // return new Attribute(fn () => $this->material()->sum('muito_bom'));
        return $this->where(['material_id' => $id, 'muito_bom' => true])->count();
    }

    public function excelente($id)
    {
        // return new Attribute(fn () => $this->material()->sum('excelente'));
        return $this->where(['material_id' => $id, 'excelente' => true])->count();
    }
}
