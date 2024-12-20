<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class IssuesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Giả sử tạo 50 vấn đề báo cáo
        // computer_id lấy ngẫu nhiên từ 1 đến 20 (tương ứng với ComputersTableSeeder)
        // urgency lấy từ ['Low', 'Medium', 'High']
        // status lấy từ ['Open', 'In Progress', 'Resolved']

        $urgencies = ['Low', 'Medium', 'High'];
        $statuses = ['Open', 'In Progress', 'Resolved'];

        for ($i = 0; $i < 50; $i++) {
            DB::table('issues')->insert([
                'computer_id' => $faker->numberBetween(1, 20),
                'reported_by' => $faker->optional()->name(),
                'reported_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'description' => $faker->paragraph(),
                'urgency' => $faker->randomElement($urgencies),
                'status' => $faker->randomElement($statuses),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}