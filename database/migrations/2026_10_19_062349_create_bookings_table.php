<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('hotel_id');
            $table->string('customer_name', 255);
            $table->string('customer_contact', 255);
            $table->timestamp('chekin_time')->nullable();
            $table->timestamp('chekout_time')->nullable();
            $table->timestamps();

            $table->foreign('hotel_id')
                ->references('hotel_id')->on('hotels')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
