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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            
            // Iniuugnay nito ang attendance sa employee record
            // Siguraduhin na ang table name mo ay 'employees'
            $table->foreignId('employee_id')
                  ->constrained()
                  ->onDelete('cascade'); 
            
            $table->date('date'); // Ang petsa ng attendance
            $table->time('time_in')->nullable(); // Oras ng pag-login
            $table->time('time_out')->nullable(); // Oras ng pag-logout
            
            // Status: 'Present', 'Late', 'Absent', or 'On Leave'
            $table->string('status')->default('Present'); 
            
            $table->timestamps(); // created_at at updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};