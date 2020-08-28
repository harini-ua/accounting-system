<?php

use Illuminate\Database\Seeder;
use App\Enums\Position;

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
            'position_id' => Position::CEO,
        ]);
        \App\User::create([
            'name' => 'Client',
            'email' => 'client@dreamdev.solutions',
            'password' => bcrypt('12344321'),
            'position_id' => Position::SysAdmin,
        ]);
        if (app()->isLocal()) {
            $positions = \App\Models\Position::all();
            factory(\App\User::class, 100)->create([
                'position_id' => function() use ($positions) {
                    return $positions->random()->id;
                }
            ]);
        }
    }
}
