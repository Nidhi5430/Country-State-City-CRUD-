<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $india = Country::create(['name' => 'India', 'iso_code' => 'IN']);
        $usa = Country::create(['name' => 'United States', 'iso_code' => 'US']);

        $mh = State::create(['country_id' => $india->id, 'name' => 'Maharashtra']);
        $gj = State::create(['country_id' => $india->id, 'name' => 'Gujarat']);
        $ca = State::create(['country_id' => $usa->id, 'name' => 'California']);

        City::create(['state_id' => $mh->id, 'name' => 'Mumbai']);
        City::create(['state_id' => $mh->id, 'name' => 'Pune']);
        City::create(['state_id' => $gj->id, 'name' => 'Ahmedabad']);
        City::create(['state_id' => $ca->id, 'name' => 'San Francisco']);
    }
}
