<?php

// app/Models/Tratamiento.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    protected $fillable = ['nombre', 'duracion', 'precio', 'descripcion'];
}
