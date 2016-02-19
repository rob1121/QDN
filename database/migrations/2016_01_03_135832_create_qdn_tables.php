<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQdnTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('infos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('control_id');
			$table->string('customer');
			$table->string('package_type');
			$table->string('device_name');
			$table->string('lot_id_number');
			$table->string('lot_quantity');
			$table->string('job_order_number');
			$table->string('machine');
			$table->string('station');
			$table->string('major');
			$table->string('disposition');
			$table->string('problem_description');
			$table->string('failure_mode');
			$table->string('discrepancy_category');
			$table->string('quantity');
			$table->timestamps();
		});

		Schema::create('cause_of_defects', function (Blueprint $table) {
			$table->integer('info_id')->unsigned()->unique();
			$table->string('cause_of_defect');
			$table->string('cause_of_defect_description');
			$table->string('objective_evidence');
			$table->timestamps();
		});

		Schema::create('containment_actions', function (Blueprint $table) {
			$table->integer('info_id')->unsigned()->unique();
			$table->string('what');
			$table->string('who');
			$table->string('objective_evidence');
			$table->timestamps();
		});

		Schema::create('corrective_actions', function (Blueprint $table) {
			$table->integer('info_id')->unsigned()->unique();
			$table->string('what');
			$table->string('who');
			$table->string('objective_evidence');
			$table->timestamps();
		});

		Schema::create('preventive_actions', function (Blueprint $table) {
			$table->integer('info_id')->unsigned()->unique();
			$table->string('what');
			$table->string('who');
			$table->string('objective_evidence');
			$table->timestamps();
		});

		Schema::create('closures', function (Blueprint $table) {
			$table->integer('info_id')->unsigned()->unique();
			$table->string('containment_action_taken');
			$table->string('corrective_action_taken');
			$table->string('close_by');
			$table->string('date_sign');
			$table->string('production');
			$table->string('process_engineering');
			$table->string('quality_assurance');
			$table->string('other_department');
			$table->string('status');
			$table->timestamps();
		});

		Schema::create('involve_people', function (Blueprint $table) {
			$table->integer('info_id')->unsigned();
			$table->string('department');
			$table->string('originator_id');
			$table->string('originator_name');
			$table->string('receiver_id');
			$table->string('receiver_name');
			$table->timestamps();
		});

		Schema::create('qdn_cycles', function (Blueprint $table) {
			$table->integer('info_id')->unsigned()->unique();
			$table->string('cycle_time');
			$table->string('production_cycle_time');
			$table->string('process_engineering_cycle_time');
			$table->string('quality_assurance_cycle_time');
			$table->string('other_department_cycle_time');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('infos');
		Schema::drop('cause_of_defects');
		Schema::drop('containment_actions');
		Schema::drop('corrective_actions');
		Schema::drop('preventive_actions');
		Schema::drop('closures');
		Schema::drop('involve_people');
		Schema::drop('qdn_cycles');
	}
}
