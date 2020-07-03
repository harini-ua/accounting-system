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
        \App\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123calculator123'),
            'position_id' => 1,
        ]);

        $positions = \App\Models\Position::all();
        factory(\App\User::class, 100)->create([
            'position_id' => function() use ($positions) {
                return $positions->random()->id;
            }
        ]);
    }
}
