<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('dni')->default('');
            $table->string('email')->unique()->default('');
            $table->string('password', 60)->default('');
            $table->string('career')->default('');
            $table->string('profile_photo')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('reset_password_token')->nullable();
            $table->boolean('reset_password_used')->default(false);
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
