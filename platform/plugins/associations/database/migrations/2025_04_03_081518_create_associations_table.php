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
        Schema::create('associations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('type')->nullable();
                $table->string('activity')->nullable();
                $table->string('location')->nullable();
                $table->text('address')->nullable();
                $table->text('association_details')->nullable();
                $table->string('image')->nullable();
                $table->string('background')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('website')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->string('instagram')->nullable();
                $table->string('communication')->nullable();
                $table->decimal('commission', 5, 2)->default(0.00);
                $table->boolean('status')->default(1); 
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending'); // New column for approval
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
