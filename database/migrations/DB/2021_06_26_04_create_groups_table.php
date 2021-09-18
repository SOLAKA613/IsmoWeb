<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('level_id')->nullable()->unsigned();
            $table->bigInteger('time_planning_id')->nullable()->unsigned();
            $table->text('name');
            $table->timestamps();
            $table->foreign('level_id')->references('id')->on('levels')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('time_planning_id')->references('id')->on('time_plannings')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
