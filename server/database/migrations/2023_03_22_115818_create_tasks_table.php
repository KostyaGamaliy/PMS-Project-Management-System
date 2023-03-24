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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('user_id')->nullable()->constrained();
            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreignId('assigner_id')->constrained('users', 'id');
            $table->unsignedBigInteger('assigner_id')->unsigned();
            $table->foreign('assigner_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreignId('board_id')->nullable()->constrained();
            $table->unsignedBigInteger('dashboard_id')->unsigned();
            $table->foreign('dashboard_id')->references('id')->on('dashboards')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('status')->default('Not started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
