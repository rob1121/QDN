<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\Account;
class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $rows = Employee::all();
        foreach ($rows as $row) {
            Employee::find($row->id)
            ->account()
            ->where('employee_id',$row->user_id)
            ->update([
                'access_level' => $faker->randomElement(['User','Admin']),
                'status' => $faker->randomElement(['Active','Deactivated']),
                'password' => bcrypt('8d')
            ]);
        }
    }
}
