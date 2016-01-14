<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            // Schema::create('accounts', function (Blueprint $table) {
            //     $table->integer('employee_id')->unsigned();
            //     $table->string('password', 60);
            //     $table->string('access_level');
            //     $table->string('status');
            //     $table->rememberToken();
            //     $table->timestamps();
            // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::drop('accounts');

    }
}
