<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_attendance', function (Blueprint $table) {
          $table->date('date');
          $table->uuid('student_id');
          $table->uuid('attendance_id');
          $table->enum('status',['Present','Absent','Late','Leave Early'])->default('present');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_attendance');
    }
}
