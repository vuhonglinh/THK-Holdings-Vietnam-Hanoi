<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'hotel_id',
        'customer_name',
        'customer_contact',
        'chekin_time',
        'chekout_time',
    ];

    protected $casts = [
        'chekin_time' => 'datetime',
        'chekout_time' => 'datetime',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
}
