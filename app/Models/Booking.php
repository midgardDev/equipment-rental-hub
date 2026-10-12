<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'renter_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'renter_message'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function renter() {
        return $this->belongsTo(User::class, 'renter_id');
    }

    public function review() {
        return $this->hasOne(Review::class);
    }

    // Check if the booking is approved
    public function isActive() {
        return $this->status === 'approved';
    }

    // Check if the booking can be reviewed
    public function canBeReviewed()
    {
        return $this->status === 'completed' && !$this->review;
    }
}
