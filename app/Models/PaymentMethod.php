<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'card_number', 'card_holder',
        'expiry_month', 'expiry_year', 'cvv', 'is_default'
    ];

    protected $hidden = ['cvv'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
