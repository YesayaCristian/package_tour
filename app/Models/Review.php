<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_package_id',
        'order_id',
        'rating',
        'comment',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scope untuk review yang approved
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope untuk review yang pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Cek apakah user sudah memberikan review untuk paket ini
    public static function hasUserReviewed($userId, $tourPackageId)
    {
        return static::where('user_id', $userId)
                    ->where('tour_package_id', $tourPackageId)
                    ->exists();
    }

    // Cek apakah order sudah direview
    public static function hasOrderReviewed($orderId)
    {
        return static::where('order_id', $orderId)->exists();
    }
}