<?php

use Illuminate\Database\Seeder;
use App\OptionModels\Option;
use App\OptionModels\Station;
use App\OptionModels\Machine;
class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::where('id','<>', 'null')->delete();
        Machine::where('id','<>', 'null')->delete();
        Station::where('id','<>', 'null')->delete();

        $faker = \Faker\Factory::create();
        Option::create(['customer' => 'adgt']);
        Option::create(['customer' => 'ams']);
        Option::create(['customer' => 'cml']);
        Option::create(['customer' => 'maxim']);
        Option::create(['customer' => 'microchip']);

        Machine::create(['name' => 'at01']);
        Machine::create(['name' => 'at02']);
        Machine::create(['name' => 'at03']);
        Machine::create(['name' => 'at04']);
        Machine::create(['name' => 'at05']);

        Station::create(['station' => 'pl1']);
        Station::create(['station' => 'pl2']);
        Station::create(['station' => 'pl3']);
        Station::create(['station' => 'pl4']);
        Station::create(['station' => 'pl5']);
    }
}
