<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class ServicioIncluye extends Model
{

    protected $fillable = ['servicio_id', 'caracteristica'];
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
