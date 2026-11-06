<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machine_telemetries', function (Blueprint $table) {
            $table->id();

            $table->decimal('temperature', 5, 2)->nullable();

            $table->string('heater_status')->default('unknown');

            $table->string('connection_status')->default('connected');

            $table->string('source')->default('SIMULATED');

            $table->timestamp('received_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machine_telemetries');
    }
};
