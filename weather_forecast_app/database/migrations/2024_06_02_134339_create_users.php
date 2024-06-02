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
            $table->bigIncrements('id')->unsigned(); // PK
            $table->string('user_id', 255)->collation('utf8mb4_unicode_ci')->unique(); // UK
            $table->integer('prefecture', false, true)->length(20)->nullable();
            $table->integer('city', false, true)->length(20)->nullable();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->timestamps(0);
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
