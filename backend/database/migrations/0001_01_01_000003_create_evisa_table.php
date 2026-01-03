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
        Schema::create('evisa', function (Blueprint $table) {
            $table->id();
            $table->string('passport_no', 50);
            $table->string('applicant_name', 255);
            $table->string('country', 100);
            $table->enum('visa_type', ['tourist', 'business', 'student', 'work']);
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->timestamps();
        });    

        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    
        Schema::create('template_buying', function (Blueprint $table) {
            $table->id();
            $table->string('template_name', 255);
            $table->decimal('template_price', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    
        Schema::create('visa_types', function (Blueprint $table) {
            $table->id();
            $table->string('text', 255);
            $table->string('value', 255);
            $table->decimal('price', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evisa');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('template_buying');
        Schema::dropIfExists('visa_types');
    }
};