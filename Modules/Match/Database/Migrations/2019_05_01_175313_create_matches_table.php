<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('set');
            $table->bigInteger('question');

            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });

        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('match');

            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });

        Schema::create('match_set', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('set_id');
            $table->bigInteger('match_user_id');
            $table->bigInteger('win')->nullable();

            $table->timestamps();
        });

        Schema::create('match_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('first_user');
            $table->bigInteger('second_user')->nullable();
            $table->bigInteger('match_id')->nullable();
            $table->bigInteger('set_id')->nullable();
            $table->bigInteger('win')->nullable();

            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('match_id');
            $table->bigInteger('match_set_id');
            $table->bigInteger('point');

            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');

            $table->foreign('question_id')->references('id')->on('questions');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
        Schema::dropIfExists('match_user');
        Schema::dropIfExists('match_set');
        Schema::dropIfExists('matches');
        Schema::dropIfExists('sets');
    }
}
