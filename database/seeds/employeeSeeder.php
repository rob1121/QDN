<?php

use App\Employee;
use App\Question;
use App\User;
use Illuminate\Database\Seeder;

class employeeSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('employees')->delete();
		$faker = \Faker\Factory::create();

		/**
		 * this for admin account
		 */
		$emp = Employee::create([
			'user_id'    => 801,
			'name'       => 'Robinson L. Legaspi',
			'department' => 'quality_assurance',
			'station'    => 'DCC',
			'position'   => 'Management System Officer',
			'email'      => 'robinsonlegaspi@astigp.com',
			'status'     => 'active',
		]);

		User::create([
			'employee_id'  => 801,
			'access_level' => 'admin',
			'password'     => 'admin',
		]);

		Question::create([
			'user_id'  => $emp->user_id,
			'question' => 'What are you?',
			'answer'   => 'user',
		]);

		/**
		 * this for process account
		 */
		$emp = Employee::create([
			'user_id'    => 802,
			'name'       => 'Nepthal Dave S. Pakingan',
			'department' => 'process_engineering',
			'station'    => 'Process Engineer',
			'position'   => 'HR Programmer',
			'email'      => 'robinsonlegaspi@astigp.com',
			'status'     => 'active',
		]);

		User::create([
			'employee_id'  => 802,
			'access_level' => 'signatory',
			'password'     => 'user',
		]);

		Question::create([
			'user_id'  => $emp->user_id,
			'question' => 'What are you?',
			'answer'   => 'user',
		]);

		/**
		 * this for dummy account
		 */
		foreach (range(1, 200) as $index) {
			$department = $faker->randomElement(['production', 'process_engineering', 'quality_assurance', 'other_department']);

			$station['quality_assurance']   = ['quality assurance'];
			$station['process_engineering'] = ['process engineering'];
			$station['production']          = ['pl1', 'pl2', 'pl3', 'pl4', 'pl7', 'pl9'];
			$station['other_department']    = ['equipment engineering', 'facilities', 'mis', 'human resource', 'purchasing and logistics', 'finance', 'utilities'];

			$emp = Employee::create([
				'user_id'    => $faker->unique()->randomNumber,
				'name'       => $faker->name('male' | 'female'),
				'department' => $department,
				'station'    => $faker->randomElement($station[$department]),
				'position'   => $faker->randomElement(['Supervisor', 'Operator', 'Manager']),
				'status'     => $faker->randomElement(['active', 'resigned']),
				'email'      => $faker->email,
			]);

			User::create([
				'employee_id'  => $emp->user_id,
				'access_level' => $faker->randomElement(['user', 'signatory']),
				'password'     => '8d',
			]);

			Question::create([
				'user_id'  => $emp->user_id,
				'question' => 'What are you?',
				'answer'   => 'user',
			]);
		}
	}
}
