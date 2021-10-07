<?php

use App\Models\Offer;
use App\Models\Person;
use Illuminate\Database\Seeder;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $people = Person::all();

        foreach ($people as $person) {
            factory(Offer::class)
                ->create([
                    'employee_id' => $person->id,
                    'start_date' => $person->start_date,
                    'bonuses' => $person->bonuses_reward,
                    'salary' => $person->salary,
                ]);
        }
    }
}
