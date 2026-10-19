<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotel extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var array
     */
    protected $guarded = ['hotel_id'];

    /**
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * Search hotel by hotel name
     *
     * @param string $hotelName
     * @return array
     */
    static public function getHotelListByName(?string $hotelName = null, $prefectureId = null): array
    {
        $query = Hotel::query()->with('prefecture');

        if (filled($hotelName)) {
            $escaped = addcslashes($hotelName, '%_\\');
            $query->where('hotel_name', 'like', "%{$escaped}%");
        }

        if (filled($prefectureId)) {
            $query->where('prefecture_id', $prefectureId);
        }

        return $query->get()->toArray();

    }

    /**
     * Override serializeDate method to customize date format
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public function bookings()
    {
        return $this->hasMany(Booking::class, 'hotel_id', 'hotel_id');
    }
}
