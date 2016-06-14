<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUserAndEmployeeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function ($table) {
			$table->dropColumn('status');
			$table->string('avatar');
		});
		Schema::table('employees', function ($table) {
			$table->string('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function ($table) {
			$table->string('status');
		});
		Schema::table('employees', function ($table) {
			$table->dropColumn('status');
		});
	}
}
