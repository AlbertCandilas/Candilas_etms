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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('attendance_statuses')->onDelete('set null');
            $table->foreignId('verified_by')->nullable()->constrained('administrators')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
