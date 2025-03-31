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
        Schema::create('train_stops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_schedule_id');
            $table->foreign('train_schedule_id')->references('id')->on('train_schedules')->onDelete('cascade');
            $table->unsignedBigInteger('station_id');
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->time('arrival_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_stops');
    }
};
