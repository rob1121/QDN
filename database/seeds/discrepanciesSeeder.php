<?php

use App\OptionModels\Discrepancy;
use Illuminate\Database\Seeder;

class discrepanciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        collect([
        ['name' => 'MISSING UNIT(S)', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'LOW YIELD', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'WRONG TRANSACTION', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'CANT CREATE', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'FOREIGN MATERIAL', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'WRONG MERGING', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'DATECODE DISCREPANCY', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'MARKING PROBLEM', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'MIXED DEVICE', 'category' => '', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'BENT LEAD', 'category' => 'LEAD ISSUE', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'LEAD CONTAMINATION', 'category' => 'LEAD ISSUE', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'LEAD DISCOLORATION', 'category' => 'LEAD ISSUE', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'LEAD COPLANARITY', 'category' => 'LEAD ISSUE', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'LABEL SWAPPING', 'category' => 'LABEL ISSUE', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'WRONG LABEL', 'category' => 'LABEL ISSUE', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'OTHER LABEL RELATED ISSUE', 'category' => 'LABEL ISSUE', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' =>'EXCESS', 'category' => 'QUANTITY DISCREPANCY', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' =>'LACKING', 'category' => 'QUANTITY DISCREPANCY', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'PACKAGE CHIP-OUT', 'category' => 'PACKAGE DEFECTS', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'PACKAGE SCRATCH', 'category' => 'PACKAGE DEFECTS', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'PACKAGE VOID', 'category' => 'PACKAGE DEFECTS', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'OTHER PACKAGE RELATED DEFECT', 'category' => 'PACKAGE DEFECTS', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'POOR SEALING', 'category' => 'TAPE AND REEL SEALING PROBLEM', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'UNSEALED COVER TAPE', 'category' => 'TAPE AND REEL SEALING PROBLEM', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'OTHER TAPE AND REEL SEALING PROBLEM', 'category' => 'TAPE AND REEL SEALING PROBLEM', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'EXPOSED LOT', 'category' => 'FINAL PACKING PROBLEM', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'OTHER FINAL PACKING PROBLEM', 'category' => 'FINAL PACKING PROBLEM', 'is_major' => 'true', 'with_lot_involved' => 'true'],
        ['name' => 'SOP VIOLATION', 'category' => '', 'is_major' => 'false', 'with_lot_involved' => 'false'],
        ['name' => 'KDTM VIOLATION', 'category' => '', 'is_major' => 'false', 'with_lot_involved' => 'false'],
        ['name' => 'OTHERS', 'category' => '', 'is_major' => 'false', 'with_lot_involved' => 'false'],
    ])->map(function($disc){
            Discrepancy::create([
                'name'  => $disc['name'],
                'category' => $disc['category'],
                'is_major'     => $disc['is_major'],
                'with_lot_involved' => $disc['with_lot_involved'],
            ]);
        });
    }
}
