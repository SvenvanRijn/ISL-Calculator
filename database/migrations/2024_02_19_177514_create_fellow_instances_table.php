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
        Schema::create('fellow_instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_fellow_id');
            $table->integer('uses');
            $table->unsignedBigInteger('mine_instance_id');
            $table->timestamps();

            $table->foreign('mine_instance_id')->references('id')->on('mine_instances');
            $table->foreign('user_fellow_id')->references('id')->on('user_fellows');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fellow_instances');
    }
};
