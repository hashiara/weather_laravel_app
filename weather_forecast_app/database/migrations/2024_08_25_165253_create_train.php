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
        Schema::create('train', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 33)->unique();
            $table->integer('area_code')->nullable();
            $table->integer('rail_order')->nullable();
            $table->string('last_train_status', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train');
    }
};
