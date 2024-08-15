<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Agent::create([
            'name' => 'Sijunjung Travel Agency',
            'address' => 'Jalan Raya Sijunjung No. 1',
            'phone' => '081234567890',
            'email' => 'info@sijunjungtravel.com',
            'website' => 'https://sijunjungtravel.com',
            'is_active' => true,
        ]);

        Agent::create([
            'name' => 'Bukit Tinggi Inn',
            'address' => 'Jalan Perbukitan No. 3',
            'phone' => '081234567891',
            'email' => 'contact@bukittinggiinn.com',
            'website' => 'https://bukittinggiinn.com',
            'is_active' => true,
        ]);

        Agent::create([
            'name' => 'Ngarai Sianok Restaurant',
            'address' => 'Jalan Ngarai Sianok No. 5',
            'phone' => '081234567892',
            'email' => 'reservations@ngaraisianokresto.com',
            'website' => 'https://ngaraisianokresto.com',
            'is_active' => true,
        ]);

        Agent::create([
            'name' => 'Gua Sijunjung Guide Services',
            'address' => 'Jalan Gua No. 7',
            'phone' => '081234567893',
            'email' => 'info@guasijunjungguides.com',
            'website' => 'https://guasijunjungguides.com',
            'is_active' => true,
        ]);

        Agent::create([
            'name' => 'Sijunjung Waterfall Adventure',
            'address' => 'Jalan Air Terjun No. 9',
            'phone' => '081234567894',
            'email' => 'contact@waterfalladventure.com',
            'website' => 'https://waterfalladventure.com',
            'is_active' => true,
        ]);

        Agent::create([
            'name' => 'Sijunjung Local Homestay',
            'address' => 'Jalan Homestay No. 11',
            'phone' => '081234567895',
            'email' => 'info@localsijunjungstay.com',
            'website' => 'https://localsijunjungstay.com',
            'is_active' => true,
        ]);
    }
}
