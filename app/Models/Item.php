<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price_per_day',
        'category',
        'location',
        'image_url',
        'is_available',
    ];
    
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable() {
        return $this->is_available;
    }
}
