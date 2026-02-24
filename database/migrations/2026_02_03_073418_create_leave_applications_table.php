<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('leave_applications', function (Blueprint $table) {
        $table->id();
        $table->string('employeeName');
        $table->string('employeeId');
        $table->string('leaveType');
        $table->string('department');
        $table->date('startDate');
        $table->date('endDate');
        $table->string('dayType'); // full, half_am, half_pm
        $table->decimal('totalDays', 4, 1);
        $table->text('reason');
        $table->string('contactInfo')->nullable();
        $table->text('handoverNotes')->nullable();
        $table->string('status')->default('pending'); // pending, accepted, declined
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_applications');
    }
};
