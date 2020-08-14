<?php

use Illuminate\Database\Seeder;
use App\Models\Holiday;
use Illuminate\Support\Facades\Schema;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Holiday::withoutEvents(function() {
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'New Year',
                'date' => '2020-01-01',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Christmas Ortodox',
                'date' => '2020-01-07',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Women’s day',
                'date' => '2020-03-08',
                'moved_date' => '2020-03-09',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Easter',
                'date' => '2020-04-19',
                'moved_date' => '2020-04-20',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'May Day',
                'date' => '2020-05-01',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Victory day',
                'date' => '2020-05-09',
                'moved_date' => '2020-05-11',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Trinity',
                'date' => '2020-06-07',
                'moved_date' => '2020-06-08',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Constitution day',
                'date' => '2020-06-28',
                'moved_date' => '2020-06-29',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Independence day',
                'date' => '2020-08-24',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Defender of ukraine day',
                'date' => '2020-10-14',
            ]);
            Holiday::create([
                'calendar_year_id' => 1,
                'name' => 'Christmas Catholic',
                'date' => '2020-12-25',
            ]);
        });

        Schema::enableForeignKeyConstraints();
    }
}
