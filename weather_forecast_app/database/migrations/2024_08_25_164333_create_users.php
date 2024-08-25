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
            $table->id();                                           // id
            $table->string('user_id', 33)->unique();                // LineユーザーID
            $table->string('mail', 255)->nullable()->unique();      // メールアドレス
            $table->string('password', 255)->nullable();            // パスワード
            $table->string('user_name', 50)->nullable();            // ユーザー名
            $table->date('birth')->nullable();                      // 生年月日
            $table->string('otk', 12)->nullable()->unique();        // ワンタイム認証キー
            $table->timestamps();                                   // 作成日時 更新日時
            $table->softDeletes();                                  // 削除日時
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
