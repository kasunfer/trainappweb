<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->unsignedBigInteger('train_id');
            $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')->references('id')->on('train_schedules')->onDelete('cascade');
            $table->unsignedBigInteger('seat_id');
            $table->foreign('seat_id')->references('id')->on('train_seats')->onDelete('cascade');
            $table->unsignedBigInteger('from_station_id');
            $table->foreign('from_station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->unsignedBigInteger('to_station_id');
            $table->foreign('to_station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->string('status')->default('confirmed');
            $table->timestamps();
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
