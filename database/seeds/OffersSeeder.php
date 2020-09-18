<?php

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
        $people = \App\Models\Person::all();

        foreach ($people as $person) {
            factory(\App\Models\Offer::class)
                ->create([
                    'employee_id' => $person->id,
                    'start_date' => $person->start_date,
                    'bonuses' => $person->bonuses_reward,
                    'salary' => $person->salary,
               ]);
        }
    }
}
