<?php

use App\Employee;
use App\Models\CauseOfDefect;
use App\Models\Closure;
use App\Models\ContainmentAction;
use App\Models\CorrectiveAction;
use App\Models\Info;
use App\Models\InvolvePerson;
use App\Models\PreventiveAction;
use App\Models\QdnCycle;
use App\OptionModels\Option;
use Illuminate\Database\Seeder;

class DummyInfoSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('infos')->delete();
		$faker = \Faker\Factory::create();

		foreach (range(1, 20) as $index) {
			$employee   = Employee::all();
			$originator = $employee->random();
			$close_by   = Employee::where('station', 'quality assurance')->first();
			$issuedTo   = $employee->random();
			$major      = 'major';

			$info = Info::create([
				'control_id'           => $index,
				'customer'             => $faker->randomElement(array_flatten(Option::all('customer')->toArray())),
				'package_type'         => $faker->firstNameFemale,
				'device_name'          => $faker->address,
				'lot_id_number'        => $faker->randomDigit,
				'lot_quantity'         => $faker->randomNumber(4),
				'job_order_number'     => $faker->randomElement(['0', '1', '2']),
				'machine'              => $faker->randomElement(['at01', 'at02', 'at03', 'at04', 'at05']),
				'station'              => $faker->randomElement(['pl1', 'pl2', 'pl3', 'pl4', 'pl5']),
				'created_at'           => $faker->dateTimeThisMonth,
				'major'                => $major,
				'disposition'          => $faker->randomElement(['use as is', 'ncmr#', 'rework', 'split lot', 'shutdown', 'shipback']),
				'problem_description'  => $faker->paragraph(2),
				'failure_mode'         => $faker->randomelement(['assembly',
					'environment',
					'machine',
					'man',
					'material',
					'method / process',
				]),
				'discrepancy_category' => $faker->randomelement([
					'MISSING UNIT(S)',
					'LOW YIELD',
					'WRONG TRANSACTION',
					'CANT CREATE',
					'FOREIGN MATERIAL',
					'WRONG MERGING',
					'DATECODE DISCREPANCY',
					'MARKING PROBLEM',
					'MIXED DEVICE',
					'BENT LEAD',
					'LEAD CONTAMINATION',
					'LEAD DISCOLORATION',
					'LEAD COPLANARITY',
				]),
				'quantity'             => $faker->randomNumber(4),
			]);

			CauseOfDefect::create([
				'info_id'                     => $info->id,
				'cause_of_defect'             => $faker->randomElement([
					'PRODUCTION',
					'PROCESS',
					'MAINTENANCE',
					'FACILITIES',
					'QUALITY ASSURANCE',
					'OTHERS',
				]),
				'cause_of_defect_description' => $faker->paragraph(2),
				'created_at'                  => $info->created_at,
				'objective_evidence'          => 'N/A',
			]);

			ContainmentAction::create([
				'info_id'            => $info->id,
				'what'               => $faker->paragraph(2),
				'who'                => $faker->name('male' | 'female'),
				'created_at'         => $info->created_at,
				'objective_evidence' => 'N/A',
			]);

			CorrectiveAction::create([
				'info_id'            => $info->id,
				'what'               => $faker->paragraph(2),
				'who'                => $faker->name('male' | 'female'),
				'created_at'         => $info->created_at,
				'objective_evidence' => 'N/A',
			]);

			PreventiveAction::create([
				'info_id'            => $info->id,
				'what'               => $faker->paragraph(2),
				'who'                => $faker->name('male' | 'female'),
				'created_at'         => $info->created_at,
				'objective_evidence' => 'N/A',
			]);

			QdnCycle::create([
				'info_id'                        => $info->id,
				'cycle_time'                     => '24',
				'production_cycle_time'          => '24',
				'process_engineering_cycle_time' => '24',
				'quality_assurance_cycle_time'   => '24',
				'other_department_cycle_time'    => '24',
			]);

			InvolvePerson::create([
				'info_id'         => $info->id,
				'department'      => $originator->station,
				'originator_id'   => $originator->user_id,
				'originator_name' => $originator->name,
				'receiver_id'     => $issuedTo->user_id,
				'receiver_name'   => $issuedTo->name,
			]);

			Closure::create([
				'info_id'                  => $info->id,
				'containment_action_taken' => $faker->randomElement(['yes', 'no']),
				'corrective_action_taken'  => $faker->randomElement(['yes', 'no']),
				'close_by'                 => $close_by->name,
				'created_at'               => $info->created_at,
				'production'               => $employee->where('department', 'production')->random()->name,
				'process_engineering'      => $employee->where('department', 'process')->random()->name,
				'quality_assurance'        => $employee->where('department', 'quality assurance')->random()->name,
				'other_department'         => $employee->where('department', 'other')->random()->name,
				'status'                   => 'Closed',
			]);
		}
	}
}
