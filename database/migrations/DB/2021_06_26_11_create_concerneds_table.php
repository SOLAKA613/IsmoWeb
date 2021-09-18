<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcernedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concerneds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->nullable()->unsigned();
            $table->bigInteger('trainer_id')->nullable()->unsigned();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('trainer_id')->references('id')->on('trainers')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concerneds');
    }
}
