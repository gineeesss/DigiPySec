<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioIncluye extends Model
{
    use HasFactory;

    protected $fillable = ['servicio_id', 'caracteristica'];
}
