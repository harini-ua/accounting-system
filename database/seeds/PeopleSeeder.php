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
        factory(\App\Models\Person::class, 50)
            ->create([
                'user_id' => function(array $person) {
                    $userPositions = [
                        Position::CEO,
                        Position::COO,
                        Position::SalesManager,
                    ];
                    if (in_array($person['position_id'], $userPositions)) {
                        return factory(\App\User::class)->create()->id;
                    }
                    return null;
                }
            ]);
    }
}
