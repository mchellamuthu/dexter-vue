<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_invites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parents_id');
            $table->uuid('student_id');
            $table->uuid('class_room_id');
            $table->uuid('user_id');
            $table->string('code');
            $table->timestamp('expired_at');
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
        Schema::dropIfExists('parent_invites');
    }
}
