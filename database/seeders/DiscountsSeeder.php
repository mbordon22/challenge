<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\DiscountRange;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiscountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generar un número aleatorio de descuentos entre 15 y 30
        $numberOfDiscounts = rand(15, 30);

        // Bucle para crear descuentos
        for ($i = 0; $i < $numberOfDiscounts; $i++) {
            $discount = Discount::create([
                'name' => 'prueba ' . ($i + 1),
                'start_date' => now()->subDays(rand(1, 365))->toDateString(), // Fecha aleatoria dentro del último año
                'end_date' => now()->addDays(rand(1, 365))->toDateString(), // Fecha aleatoria dentro del próximo año
                'priority' => rand(1, 10),
                'active' => rand(0, 1),
                'region_id' => rand(1, 4),
                'brand_id' => rand(1, 3),
                'access_type_code' => ['A', 'B', 'C'][rand(0, 2)], // Tipo de acceso aleatorio
            ]);

            // Crear un número aleatorio de rangos para el descuento
            $numberOfRanges = rand(0, 2);

            // Bucle para crear rangos para el descuento
            for ($j = 0; $j <= $numberOfRanges; $j++) {
                DiscountRange::create([
                    'from_days' => rand(1, 30),
                    'to_days' => rand(31, 60),
                    'discount' => rand(0, 50),
                    'code' => 'ABC' . rand(100, 999), // Código aleatorio
                    'discount_id' => $discount->id,
                ]);
            }
        }
    }
}
