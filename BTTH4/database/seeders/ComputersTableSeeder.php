<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ComputersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Giả sử tạo 20 máy tính
        // Một số ví dụ về operating_system, processor có thể random trong danh sách cố định:
        $operatingSystems = ['Windows 10 Pro', 'Windows 11 Pro', 'Ubuntu 20.04 LTS', 'macOS Monterey'];
        $processors = ['Intel Core i5-11400', 'Intel Core i7-10700', 'AMD Ryzen 5 3600', 'AMD Ryzen 7 5800X'];
        
        for ($i = 1; $i <= 50; $i++) {
            DB::table('computers')->insert([
                'computer_name' => 'Lab' . $faker->numberBetween(1,5) . '-PC' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'model' => $faker->randomElement(['Dell Optiplex 7090', 'HP EliteDesk 800 G6', 'Lenovo ThinkCentre M720']),
                'operating_system' => $faker->randomElement($operatingSystems),
                'processor' => $faker->randomElement($processors),
                'memory' => $faker->randomElement([8, 16, 32]),
                'available' => $faker->boolean(80), // 80% là true
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}