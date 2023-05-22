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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sender_id')->nullable()->constrained('users')->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->index('sender_id', 'sender_idx');

            $table->foreignId('receiver_id')->nullable()->constrained('users')->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->index('receiver_id', 'receiver_idx');

            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
