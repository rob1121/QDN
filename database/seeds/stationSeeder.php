<?php

use App\OptionModels\Station;
use Illuminate\Database\Seeder;

class stationSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		/**
		 * this for dummy account
		 */
		$stations = [
			'pl1'                      => 'production',
			'pl2'                      => 'production',
			'pl3'                      => 'production',
			'pl4'                      => 'production',
			'pl5'                      => 'production',
			'pl7'                      => 'production',
			'pl9'                      => 'production',

			'process engineering'      => 'process_engineering',
			'fvi'                      => 'process_engineering',

			'quality assurance'        => 'quality_assurance',

			'equipment engineering'    => 'other_department',
			'facilities'               => 'other_department',
			'mis'                      => 'other_department',
			'human resource'           => 'other_department',
			'purchasing and logistics' => 'other_department',
			'finance'                  => 'other_department',
			'utilities'                => 'other_department',
		];
		foreach ($stations as $value => $key) {
			Station::create([
				'station'    => $value,
				'department' => $key,
			]);
		}
	}
}
