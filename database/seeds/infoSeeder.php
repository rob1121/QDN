<?php

use Illuminate\Database\Seeder;

use App\Models\Info;
use App\Models\ContainmentAction;
use App\Models\CauseOfDefect;
use App\Models\CorrectiveAction;
use App\Models\PreventiveAction;
use App\Models\Closure;
use App\Models\QdnCycle;
use App\Models\InvolvePerson;
class infoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('infos')->delete();
        $faker = \Faker\Factory::create();

        foreach(range(1,20) as $index)
        {
            $info = Info::create([
                'control_id'             => $index,
                'customer'             => $faker->company,
                'package_type'         => $faker->firstNameFemale,
                'device_name'          => $faker->address,
                'lot_id_number'        => $faker->randomDigit,
                'lot_quantity'         => $faker->randomNumber(4),
                'job_order_number'     => $faker->randomElement(['0','1','2']),
                'machine'              => $faker->randomElement(['at01','at02','at03','at04','at05']),
                'station'              => $faker->randomElement(['pl1','pl2','pl3','pl4','pl5']),
                'created_at'                 => $faker->dateTimeThisMonth,
                'major'                => $faker->randomElement(['major','minor']),
                'disposition'          => $faker->randomElement(['use as is','ncmr#','rework','split lot','shutdown','ship back']),
                'problem_description'  => $faker->paragraph(2),
                'failure_mode'         => $faker->word(2),
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
                'quantity' => $faker->randomNumber(4),
            ]);

            CauseOfDefect::create([
                'info_id'         =>  $info->id,
                'cause_of_defect' => $faker->randomElement([
                    'PRODUCTION',
                    'PROCESS',
                    'MAINTENANCE',
                    'FACILITIES',
                    'QUALITY ASSURANCE',
                    'OTHERS'
                ]),
                'cause_of_defect_description' => $faker->paragraph(2),
                'created_at'                  => $info->created_at,
                'objective_evidence'          => 'N/A'
            ]);

            ContainmentAction::create([
                'info_id'            =>  $info->id,
                'what'               => $faker->paragraph(2),
                'who'                => $faker->name('male' | 'female'),
                'created_at'               => $info->created_at,
                'objective_evidence' => 'N/A'
            ]);

            CorrectiveAction::create([
                'info_id'            =>  $info->id,
                'what'               => $faker->paragraph(2),
                'who'                => $faker->name('male' | 'female'),
                'created_at'               => $info->created_at,
                'objective_evidence' => 'N/A'
            ]);

            PreventiveAction::create([
                'info_id'            =>  $info->id,
                'what'               => $faker->paragraph(2),
                'who'                => $faker->name('male' | 'female'),
                'created_at'               => $info->created_at,
                'objective_evidence' => 'N/A'
            ]);

            QdnCycle::create([
                'info_id'                        => $info->id,
                'cycle_time'                     => '24',
                'production_cycle_time'          => '24',
                'process_engineering_cycle_time' => '24',
                'quality_assurance_cycle_time'   => '24',
                'other_department_cycle_time'    => '24'
            ]);

            InvolvePerson::create([
                'info_id'         => $info->id,
                'department'      => $faker->randomElement(['PL1','PL2','PL3','PL4','PL5']),
                'originator_id'   => $faker->randomNumber(3),
                'originator_name' => $faker->name,
                'receiver_id'     => $faker->randomNumber(3),
                'receiver_name'   => $faker->name,
            ]);

            Closure::create([
                'info_id'                  => $info->id,
                'containment_action_taken' => $faker->randomElement(['YES','NO']),
                'corrective_action_taken'  => $faker->randomElement(['YES','NO']),
                'close_by'                 => $faker->name('male' | 'female'),
                'created_at'                => $info->created_at,
                'production'               => $faker->name('male' | 'female'),
                'process_engineering'      => $faker->name('male' | 'female'),
                'quality_assurance'        => $faker->name('male' | 'female'),
                'other_department'         => $faker->name('male' | 'female'),
                'status'                   => 'Closed'
            ]);
        }
    }
}
