<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Season extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "titolo",
        "ordine",
        "anno",
        "trama",
        "copertina",
        "serie_id",
        "created_at",
        "updated_at",
    ];

    protected $with = [
        "episodes",
    ];
    protected $appends = ['url_copertina'];


    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
    public function getUrlCopertinaAttribute()
    {
        return preg_match('/^\/storage\/[a-zA-Z0-9.\/_]+$/', $this->copertina) ? "https://codex.lorenzobonzi.it" . $this->copertina : "https://image.tmdb.org/t/p/w500" . $this->copertina;
    }
    public function setCopertinaFromBase64($base64)
    {
        if (preg_match("/^data:image\/(?<extension>(?:png|gif|jpg|jpeg));base64,(?<image>.+)$/", $base64, $matchings)) {
            $imageData = base64_decode($matchings['image']);
            $extension = $matchings['extension'];
            $filename = "img/seasons/copertine/" . $this->id . '.' . $extension;

            if (Storage::disk('public')->put($filename, $imageData)) {
                $this->copertina = Storage::url($filename);
                $this->save();
            }
        }
    }
}