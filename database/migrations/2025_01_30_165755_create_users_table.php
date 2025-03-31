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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('username')->nullable();
            $table->string('nic')->unique()->nullable();
            $table->string('code')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('contact')->unique()->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('otp')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
