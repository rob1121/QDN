<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResetQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('question');
            $table->string('answer');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_user_id_foreign');
        });

        Schema::drop('questions');
    }
}
