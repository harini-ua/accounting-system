<?php

use Illuminate\Database\Seeder;
use App\Enums\Position;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recruiters = \App\User::where('position_id', Position::Recruiter())->get();
        factory(\App\Models\Person::class, 100)
            ->create([
                'user_id' => function (array $person) {
                    $userPositions = [
                        Position::CEO,
                        Position::COO,
                        Position::SalesManager,
                    ];
                    if (in_array($person['position_id'], $userPositions)) {
                        return factory(\App\User::class)->create([
                            'position_id' => $person['position_id'],
                        ])->id;
                    }
                    return null;
                },
                'recruiter_id' => function () use ($recruiters) {
                    return rand(0, 1) ? $recruiters->random()->id : null;
                },
            ]);
    }
}
