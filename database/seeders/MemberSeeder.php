<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $data = [
            [
                "id" => "3276011509010002",
                "family_card_id" => "3276011509010001",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
            [
                "id" => "3276011509010003",
                "family_card_id" => "3276011509010001",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
            [
                "id" => "3204120807050003",
                "family_card_id" => "3204120807050002",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
            [
                "id" => "3204120807050004",
                "family_card_id" => "3204120807050002",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
            [
                "id" => "3173052208120004",
                "family_card_id" => "3173052208120003",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
            [
                "id" => "3302141411100005",
                "family_card_id" => "3302141411100004",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
            [
                "id" => "3302141411100008",
                "family_card_id" => "3302141411100004",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
            [
                "id" => "3519080306020007",
                "family_card_id" => "3519080306020005",
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "status" => "aktif",
                "register_date" => now()
            ],
        ];

        Member::insert($data);
    }
}
