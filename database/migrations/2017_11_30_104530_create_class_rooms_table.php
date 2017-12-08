<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('class_name');
            $table->string('avatar')->nullable();
            $table->integer('institute_id')->nullable()->default(0)->unsigned();
            $table->integer('class_teacher')->default(0)->unsigned();
            $table->integer('status')->default(0)->unsigned();
            $table->integer('user_id')->default(0)->unsigned();
            $table->softDeletes();
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
        Schema::dropIfExists('class_rooms');
    }
}
