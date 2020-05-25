<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = \App\Position::all();
        factory(\App\User::class, 100)->create([
            'position_id' => function() use ($positions) {
                return $positions->random()->id;
            }
        ]);
    }
}
