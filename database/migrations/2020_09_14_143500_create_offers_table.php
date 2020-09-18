<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('start_date');
            $table->smallInteger('trial_period')->default(config('people.trial_period.value'));
            $table->date('end_trial_period_date');
            $table->smallInteger('bonuses')->nullable();
            $table->decimal('salary', 9,2);
            $table->boolean('salary_review')->default(0);
            $table->decimal('sum', 9,2)->nullable();
            $table->decimal('salary_after_review', 9,2)->nullable();
            $table->text('additional_conditions')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
