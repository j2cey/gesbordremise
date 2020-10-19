<?php

use App\BordereauremiseType;
use Illuminate\Database\Seeder;

class BordereauremiseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bordereauremisetypes = [
            [
                'code' => "BT_0", 'titre' => "Espèce"
            ],
            [
                'code' => "BT_1", 'titre' => "Chèque"
            ],
        ];
        foreach ($bordereauremisetypes as $bordereauremisetype) {
            BordereauremiseType::create($bordereauremisetype);
        }
    }
}
