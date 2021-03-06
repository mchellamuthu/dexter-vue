<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
          $table->uuid('id')->primary();
          $table->string('skill_name');
          $table->uuid('class_room_id');
          $table->uuid('institute_id');
          $table->uuid('user_id');
          $table->uuid('student_id');
          $table->integer('point');
          $table->enum('type',['Positive','Negative']);
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
        Schema::dropIfExists('points');
    }
}
