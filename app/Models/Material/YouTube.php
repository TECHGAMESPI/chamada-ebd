<?php

namespace App\Models\material;

use App\Models\material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouTube extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'url'];

    protected $appends = ['code_video'];

    public function material()
    {
        return $this->belongsTo(material::class);
    }

    public function getCodeVideoAttribute(): string
    {
        $parsedUrl = parse_url($this->url);

        if (array_key_exists('query', $parsedUrl) && str_contains("/watch", $parsedUrl['path'])) {
            $data = explode('=', $parsedUrl['query']);

            return $data[1];
        }

        if (!array_key_exists('query', $parsedUrl) && array_key_exists('path', $parsedUrl)) {
            $data = explode('/', $parsedUrl['path']);

            return $data[1];
        }

        return "";
    }
}
