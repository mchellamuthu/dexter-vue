<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
          $table->uuid('id')->primary();
            $table->uuid('institute_id')->nullable();
            $table->string('title');
            $table->string('description');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->uuid('user_id');
            $table->boolean('allday')->default(false);
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
        Schema::dropIfExists('events');
    }
}
