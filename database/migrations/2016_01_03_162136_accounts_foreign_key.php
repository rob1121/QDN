<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AccountsForeignKey extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $table) {
			$table->foreign('employee_id')
				->references('user_id')
				->on('employees')
				->onDelete('cascade');
		});

		Schema::table('qdn_cycles', function (Blueprint $table) {
			$table->foreign('info_id')
				->references('id')
				->on('infos')
				->onDelete('cascade');
		});

		Schema::table('involve_people', function (Blueprint $table) {
			$table->foreign('info_id')
				->references('id')
				->on('infos')
				->onDelete('cascade');
		});

		Schema::table('cause_of_defects', function (Blueprint $table) {
			$table->foreign('info_id')
				->references('id')
				->on('infos')
				->onDelete('cascade');
		});

		Schema::table('containment_actions', function (Blueprint $table) {
			$table->foreign('info_id')
				->references('id')
				->on('infos')
				->onDelete('cascade');
		});

		Schema::table('corrective_actions', function (Blueprint $table) {
			$table->foreign('info_id')
				->references('id')
				->on('infos')
				->onDelete('cascade');
		});

		Schema::table('preventive_actions', function (Blueprint $table) {
			$table->foreign('info_id')
				->references('id')
				->on('infos')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign('users_employee_id_foreign');
		});

		Schema::table('qdn_cycles', function (Blueprint $table) {
			$table->dropForeign('qdn_cycles_info_id_foreign');
		});

		Schema::table('involve_people', function (Blueprint $table) {
			$table->dropForeign('involve_people_info_id_foreign');
		});

		Schema::table('containment_actions', function (Blueprint $table) {
			$table->dropForeign('containment_actions_info_id_foreign');
		});

		Schema::table('cause_of_defects', function (Blueprint $table) {
			$table->dropForeign('cause_of_defects_info_id_foreign');
		});

		Schema::table('corrective_actions', function (Blueprint $table) {
			$table->dropForeign('corrective_actions_info_id_foreign');
		});

		Schema::table('preventive_actions', function (Blueprint $table) {
			$table->dropForeign('preventive_actions_info_id_foreign');
		});

		Schema::table('closures', function (Blueprint $table) {
			$table->dropForeign('closures_info_id_foreign');
		});
	}
}
