<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('cellphone')->unique();
                $table->integer('otp')->nullable();
                $table->string('login_token')->nullable();
                $table->tinyInteger('status')->default(1);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cellphone', 'otp', 'login_token', 'status']);
        });
    }
};
