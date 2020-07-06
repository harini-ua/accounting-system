<?php

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'CEO',
        ]);
        Position::create([
            'name' => 'COO',
        ]);
        Position::create([
            'name' => 'Project Manager',
        ]);
        Position::create([
            'name' => 'Manager',
        ]);
        Position::create([
            'name' => 'Sales Manager',
        ]);
        Position::create([
            'name' => 'Developer',
        ]);
        Position::create([
            'name' => 'SysAdmin',
        ]);
        Position::create([
            'name' => 'Accountant',
        ]);
    }
}
