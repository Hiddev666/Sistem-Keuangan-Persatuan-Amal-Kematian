<?php

namespace Database\Seeders;

use App\Models\FamilyCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FamilyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "id" => "3276011509010001",
                "head_member_id" => "3276011509010002",
                "password" => Hash::make("test"),
                "address" => "Jalan Cempaka Nomor 321",
                "phone" => null,
                "card_image" => null
            ],
            [
                "id" => "3204120807050002",
                "head_member_id" => "3204120807050003",
                "password" => Hash::make("test"),
                "address" => "Jalan Bunga Nomor 9121",
                "phone" => null,
                "card_image" => null
            ],
            [
                "id" => "3173052208120003",
                "head_member_id" => "3173052208120004",
                "password" => Hash::make("test"),
                "address" => "Jalan Guna Nomor 8122",
                "phone" => null,
                "card_image" => null
            ],
            [
                "id" => "3302141411100004",
                "head_member_id" => "3302141411100005",
                "password" => Hash::make("test"),
                "address" => "Jalan Puspa Nomor 282",
                "phone" => null,
                "card_image" => null
            ],
            [
                "id" => "3519080306020005",
                "head_member_id" => "3519080306020007",
                "password" => Hash::make("test"),
                "address" => "Jalan Melati Nomor 12",
                "phone" => null,
                "card_image" => null
            ],
        ];
        FamilyCard::insert($data);
    }
}
