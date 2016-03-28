<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->call(employeeSeeder::class);
		$this->command->info('employee table seeded!');
		// $this->call(CollectionOfOptionSeeder::class);
		// $this->command->info('options table seeded!');
		// $this->call(DummyInfoSeeder::class);
		// $this->command->info('infos table seeded!');
		// $this->call(stationSeeder::class);
		// $this->command->info('employee table seeded!');

	}
}
