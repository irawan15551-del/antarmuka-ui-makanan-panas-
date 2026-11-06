<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('machine_configurations', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->json('payload');
            $table->string('status')->default('pending');
            $table->json('response')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('machine_configurations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'user_id',
                'payload',
                'status',
                'response',
            ]);
        });
    }
};
