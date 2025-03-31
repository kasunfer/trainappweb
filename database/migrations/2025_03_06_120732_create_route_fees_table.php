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
        Schema::create('route_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_station_id');
            $table->foreign('from_station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->unsignedBigInteger('to_station_id');
            $table->foreign('to_station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->decimal('ticket_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_fees');
    }
};
