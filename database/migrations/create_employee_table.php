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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->unique(); // Unique ID para sa bawat employee
            $table->string('name');
            $table->string('department');
            $table->string('position');
            $table->decimal('salary', 10, 2); // 10 digits total, 2 decimal places
            $table->timestamps(); // created_at at updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};