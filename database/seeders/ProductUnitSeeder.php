<?php

namespace Database\Seeders;

use App\Models\ProductUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductUnitSeeder extends Seeder
{
    public function run()
    {
        $unitNames = [
            '/Kilogram',
            '/Gram',
            '/Pound',
            '/Ounce',
            '/Liter',
            '/Milliliter',
            '/Fluid Ounce',
            '/Gallon',
            '/Each',
            '/Piece',
            '/Dozen',
            '/Pack',
            '/Meter',
            '/Centimeter',
            '/Inch',
            '/Bushel',
            '/Crate',
            '/Pallet',
            '/Bunch',
            '/Bundle',
            '/Roll',
            '/Bag',
            // Add more unit names as needed
        ];

        foreach ($unitNames as $unitName) {
            ProductUnit::create(['unit_name' => $unitName]);
        }
    }
}
