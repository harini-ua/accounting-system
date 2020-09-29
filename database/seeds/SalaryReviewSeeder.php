<?php

use Illuminate\Database\Seeder;

class SalaryReviewSeeder extends Seeder
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
            if(random_int(0,1)) {
                factory(\App\Models\SalaryReview::class, random_int(2, 4))
                    ->create([
                       'person_id' => $person->id,
                    ]);
            }
        }
    }
}
