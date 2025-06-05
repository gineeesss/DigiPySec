<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaPlato extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function platos()
    {
        return $this->hasMany(Plato::class);
    }
}
