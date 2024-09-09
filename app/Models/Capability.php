<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capability extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "nome",
        "created_at",
        "updated_at",
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
