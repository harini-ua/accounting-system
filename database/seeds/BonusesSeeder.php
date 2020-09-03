<?php

use Illuminate\Database\Seeder;

class BonusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\Person[] $salesManagerIds */
        $salesManagerIds = \App\Models\Person::where('position_id', \App\Enums\Position::SalesManager)->get();

        $salesManagerIds->each(function (\App\Models\Person $person, $key) {
            factory(\App\Models\Bonus::class, 1)
                ->create([
                    'person_id' => $person->id,
                    'value' => 2
                ]);
        });

        $recruiterIds = \App\Models\Person::where('position_id', \App\Enums\Position::Recruiter)->get();

        $recruiterIds->each(function (\App\Models\Person $person, $key) {
            factory(\App\Models\Bonus::class, 1)
                ->create([
                    'person_id' => $person->id,
                    'value' => 4
                ]);
        });
    }
}
