<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->dateTime('expired_at')->nullable();
            $table->string('location', 120)->nullable();
            $table->string('key', 120)->unique();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->bigInteger('clicked')->default(0);
            $table->integer('order')->default(0)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
