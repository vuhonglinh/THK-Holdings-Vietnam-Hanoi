<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotelIds = Hotel::orderBy('hotel_id')->pluck('hotel_id');
        if ($hotelIds->isEmpty()) {
            return;
        }

        $rows = [
            ['山田 太郎', 'taro.yamada@example.com', '2026-11-01 14:00:00', '2026-11-03 11:00:00'],
            ['佐藤 花子', '090-1234-5678', '2026-11-05 15:00:00', '2026-11-07 10:00:00'],
            ['鈴木 一郎', 'ichiro.suzuki@example.com', '2026-11-10 14:00:00', '2026-11-12 11:00:00'],
            ['田中 美咲', '080-9876-5432', '2026-11-15 16:00:00', '2026-11-16 10:00:00'],
            ['Nguyen Van A', 'nguyenvana@example.com', '2026-11-20 14:00:00', '2026-11-23 11:00:00'],
            ['Tran Thi B', '+84 90 123 4567', '2026-12-01 15:00:00', '2026-12-04 10:00:00'],
            ['Le Van C', 'levanc@example.com', '2026-12-10 14:00:00', '2026-12-11 11:00:00'],
            ['高橋 健', '070-1111-2222', '2026-12-24 14:00:00', '2026-12-26 11:00:00'],
        ];

        foreach ($rows as $i => [$name, $contact, $in, $out]) {
            Booking::updateOrCreate(
                ['customer_name' => $name, 'chekin_time' => $in],
                [
                    'hotel_id' => $hotelIds[$i % $hotelIds->count()],
                    'customer_contact' => $contact,
                    'chekout_time' => $out,
                ]
            );
        }
    }
}
