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
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('slot_id')->constrained('parking_slots')->onDelete('cascade');
            $table->foreignId('parked_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('parked_at');
            $table->dateTime('unparked_at')->nullable();
            $table->enum('status', ['parked', 'unparked']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkings');
    }
};
