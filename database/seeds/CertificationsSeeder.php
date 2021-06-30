<?php

use Illuminate\Database\Seeder;

class CertificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        \App\Models\Person::chunk(100, static function ($people) {
            /** @var \App\Models\Person $person */
            foreach ($people as $person) {
                if (random_int(0, 1)) {
                    $certifications = factory(\App\Models\Certification::class, random_int(1, 5))
                        ->make([ 'person_id' => $person->id ]);

                    $person->certifications()->saveMany($certifications);
                }
            }
        });
    }
}
