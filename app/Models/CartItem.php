<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'tour_package_id',
        'quantity',
        'subtotal',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }
}
