<?php

namespace App\Models\material;

use App\Models\material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkExterno extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'url'];

    public function material()
    {
        return $this->belongsTo(material::class);
    }
}
