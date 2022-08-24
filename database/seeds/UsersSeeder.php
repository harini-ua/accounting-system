<?php

use App\Enums\Position;
use App\User;
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
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123calculator123'),
            'position_id' => Position::CEO,
        ]);
        User::create([
            'name' => 'Client',
            'email' => 'client@example.com',
            'password' => bcrypt('12344321'),
            'position_id' => Position::SysAdmin,
        ]);
        if (app()->isLocal()) {
            $positions = \App\Models\Position::all();
            factory(User::class, 100)->create([
                'position_id' => function () use ($positions) {
                    return $positions->random()->id;
                }
            ]);
        }
    }
}
