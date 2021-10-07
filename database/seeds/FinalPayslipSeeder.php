<?php

use App\Enums\Position;
use App\Models\Account;
use App\Models\FinalPayslip;
use App\Models\Person;
use Illuminate\Database\Seeder;

class FinalPayslipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $people = Person::whereNotNull('quited_at')->get();
        $accountIds = Account::pluck('id')->toArray();

        foreach ($people as $person) {
            factory(FinalPayslip::class, 1)->create([
                'bonuses' => function () use ($person) {
                    if ($person->position_id !== Position::SalesManager ||
                        $person->position_id !== Position::Recruiter) {
                        return json_encode([]);
                    }

                    return json_encode([
                        'USD' => random_int(10, 200),
                        'UAH' => random_int(300, 6000),
                        'EUR' => random_int(10, 200),
                    ]);
                },
                'person_id' => $person->id,
                'account_id' => static function () use ($accountIds) {
                    return $accountIds[array_rand($accountIds)];
                },
            ]);
        }
    }
}
