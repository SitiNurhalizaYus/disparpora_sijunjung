<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\InfoTempat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InfoTempatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agent1 = Agent::where('name', 'Sijunjung Travel Agency')->first();
        $agent2 = Agent::where('name', 'Bukit Tinggi Inn')->first();
        $agent3 = Agent::where('name', 'Ngarai Sianok Restaurant')->first();
        $agent4 = Agent::where('name', 'Gua Sijunjung Guide Services')->first();
        $agent5 = Agent::where('name', 'Sijunjung Waterfall Adventure')->first();
        $agent6 = Agent::where('name', 'Sijunjung Local Homestay')->first();

        InfoTempat::create([
            'agent_id' => $agent1->id,
            'name' => 'Air Terjun Lubuak Bulan',
            'description' => 'A beautiful waterfall located in the heart of Sijunjung with crystal-clear water and lush greenery.',
            'facilities' => 'Parking, Rest Area, Cafeteria',
            'operating_hours' => '08:00 - 17:00',
            'ticket_price' => 'Rp 15.000',
            'images' => 'lubuak_bulan.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'agent_id' => $agent2->id,
            'name' => 'Bukit Tinggi Hilltop',
            'description' => 'Experience breathtaking views of the Sijunjung landscape from the top of Bukit Tinggi.',
            'facilities' => 'Parking, Observation Deck, Café',
            'operating_hours' => '06:00 - 19:00',
            'ticket_price' => 'Rp 10.000',
            'images' => 'bukit_tinggi.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'agent_id' => $agent3->id,
            'name' => 'Ngarai Sianok Restaurant',
            'description' => 'A local restaurant offering traditional Minangkabau cuisine with a stunning view of Ngarai Sianok.',
            'facilities' => 'Indoor and Outdoor Seating, Parking, Free Wi-Fi',
            'operating_hours' => '10:00 - 22:00',
            'ticket_price' => 'Varies',
            'images' => 'ngarai_sianok_restaurant.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'agent_id' => $agent4->id,
            'name' => 'Gua Sijunjung',
            'description' => 'Explore the mystical Gua Sijunjung, known for its impressive stalactites and stalagmites.',
            'facilities' => 'Guided Tours, Souvenir Shop, Rest Area',
            'operating_hours' => '08:00 - 16:00',
            'ticket_price' => 'Rp 20.000',
            'images' => 'gua_sijunjung.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'agent_id' => $agent5->id,
            'name' => 'Waterfall Adventure Park',
            'description' => 'A thrilling adventure park offering activities like trekking and rafting near the Sijunjung waterfalls.',
            'facilities' => 'Adventure Equipment Rental, Rest Area, Café',
            'operating_hours' => '07:00 - 18:00',
            'ticket_price' => 'Rp 25.000',
            'images' => 'waterfall_adventure_park.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'agent_id' => $agent6->id,
            'name' => 'Sijunjung Local Homestay',
            'description' => 'Experience local hospitality in Sijunjung with comfortable homestay options.',
            'facilities' => 'Wi-Fi, Breakfast Included, Parking',
            'operating_hours' => '24/7',
            'ticket_price' => 'Rp 150.000 per night',
            'images' => 'sijunjung_homestay.jpg',
            'is_active' => true,
        ]);
    }
}
