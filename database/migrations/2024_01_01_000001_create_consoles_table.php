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
        Schema::create('consoles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Console name/identifier');
            $table->string('type')->comment('Console type (PS4, PS5, etc.)');
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->string('iot_device_id')->unique()->comment('IoT device identifier');
            $table->boolean('is_online')->default(false)->comment('Device connection status');
            $table->decimal('hourly_rate', 8, 2)->comment('Hourly rental rate');
            $table->timestamps();
            
            $table->index(['status', 'type']);
            $table->index('is_online');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consoles');
    }
};