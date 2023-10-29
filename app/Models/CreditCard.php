<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBrandIconAttribute()
    {
        $icon = [
            'Visa' => 'fa-brands fa-cc-visa',
            'MasterCard' => 'fa-brands fa-cc-mastercard',
            'JCB' => 'fa-brands fa-cc-jcb',
            'American Express' => 'fa-brands fa-cc-amex',
            'Diners Club' => 'fa-brands fa-cc-diners-club',
            'Discover' => 'fa-brands fa-cc-discover',
        ];

        if(!empty($icon[$this->brand])) {
            $brand = $icon[$this->brand];
        } else {
            $brand = 'fa-solid fa-credit-card';
        }

        return $brand;
    }
}
