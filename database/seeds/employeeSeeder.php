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
		foreach (range(1, 15) as $index) {
			$department = $faker->randomElement(['quality assurance', 'process', 'other', 'production']);

			$station['quality assurance'] = ['quality assurance'];
			$station['process']           = ['process engineering'];
			$station['production']        = ['pl1', 'pl2', 'pl3', 'pl4', 'pl7', 'pl9'];
			$station['other']             = ['equipment engineering', 'facilities', 'mis', 'human resource', 'purchasing and logistics', 'finance', 'utilities'];

			$emp = Employee::create([
				'user_id'    => $faker->unique()->randomNumber,
				'name'       => $faker->name('male' | 'female'),
				'department' => $department,
				'station'    => $faker->randomElement($station[$department]),
				'position'   => $faker->randomElement(['Supervisor', 'Operator', 'Manager']),
			]);

			User::create([
				'employee_id'  => $emp->user_id,
				'access_level' => $faker->randomElement(['User', 'Admin']),
				'status'       => $faker->randomElement(['Active', 'Deactivated']),
				'password'     => bcrypt('8d'),
			]);

			Question::create([
				'user_id'  => $emp->user_id,
				'question' => 'What are you?',
				'answer'   => 'user',
			]);
		}
	}
}
