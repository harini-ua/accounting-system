<?php

namespace App\Jobs;

use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class AccrualVacation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();
        Person::whereDay('start_date', $now->day)
            ->whereMonth('start_date', $now->month)
            ->whereDate('start_date', '!=', $now)
            ->get()
            ->each(function($person) {
                if ($person->available_vacations) {
                    $person->compensate = true;
                    $person->compensated_days = null;
                    $person->compensated_at = null;
                }
                $person->available_vacations = $person->available_vacations + 15;
                $person->save();
            });
    }
}
