<?php

use App\Enums\Position;
use App\Models\Person;
use App\User;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recruiters = User::where('position_id', Position::Recruiter)->get();
        factory(Person::class, 100)
            ->create([
                'user_id' => function (array $person) {
                    $userPositions = [
                        Position::CEO,
                        Position::COO,
                        Position::SalesManager,
                    ];
                    if (in_array($person['position_id'], $userPositions)) {
                        return factory(User::class)->create([
                            'position_id' => $person['position_id'],
                        ])->id;
                    }
                    return null;
                },
                'recruiter_id' => function () use ($recruiters) {
                    return random_int(0, 1) ? $recruiters->random()->id : null;
                },
            ]);
    }
}
