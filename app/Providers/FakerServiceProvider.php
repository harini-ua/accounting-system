<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Provider\Base;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Faker', function ($app) {
            $faker = Factory::create();

            /**
             * Faker provider for credible and typical prices
             */
            $newClass = new class($faker) extends Base {
                const DECIMALS = [0.29, 0.49, 0.99];

                /**
                 * Provides a natural looking price between $min and $max.
                 * It will also round it to the nearest tenth and substract 1 to give it a psychological impact.
                 * Then it will add pricing typical decimals (X.29 or X.99)
                 *
                 * @param integer $min
                 * @param integer $max
                 * @param boolean $tenths
                 * @param boolean $psychologicalPrice
                 * @param boolean $decimals
                 * @return float
                 */
                public function price($min = 1000, $max = 20000, $tenths = true, $psychologicalPrice = true, $decimals = true): float
                {
                    if ($decimals) {
                        $price = $this->generator->randomFloat($min, $max, 2);
                    } else {
                        $price = $this->generator->numberBetween($min, $max);
                    }

                    if ($tenths) {
                        $price = round($price, -1);
                        if ($psychologicalPrice) {
                            --$price;
                        }
                    }

                    if ($decimals) {
                        $price += $this->generator->randomElement(self::DECIMALS);
                    }

                    return $price;
                }
            };

            $faker->addProvider($newClass);

            return $faker;
        });
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
