<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

//    protected $table = 'clients';

    protected $fillable = [
        'user_id',
        'phone',
        'company_name',
        'tax_id'
    ];

// Relación con el usuario (Jetstream)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
