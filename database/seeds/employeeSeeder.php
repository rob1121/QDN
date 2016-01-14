<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\User;
use App\Question;
class employeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('employees')->delete();
        $faker = \Faker\Factory::create();
        foreach(range(1,15) as $index)
        {
            $emp = Employee::create([
                        'user_id'    => $faker->unique()->randomNumber,
                        'name'       => $faker->name('male'|'female'),
                        'department' => $faker->randomElement(['QA','PE','MIS']),
                        'position'   => $faker->randomElement(['Supervisor','Operator','Manager'])
                   ]);

            User::create([
                'employee_id'  => $emp->user_id,
                'access_level' => $faker->randomElement(['User','Admin']),
                'status'       => $faker->randomElement(['Active','Deactivated']),
                'password'     => bcrypt('8d')
            ]);

            Question::create([
                'user_id'  => $emp->user_id,
                'question' => 'What are you?',
                'answer'   => 'user'
            ]);
        }
    }
}
