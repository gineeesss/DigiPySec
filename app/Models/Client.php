<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

//    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_id' // Responsable del cliente
    ];

// Relación con el usuario (Jetstream)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
