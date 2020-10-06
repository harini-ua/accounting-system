<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('calendar_month_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('account_id');

            $table->smallInteger('worked_days');
            $table->decimal('worked_hours', 5, 2);
            $table->decimal('earned', 9, 2);
            $table->decimal('overtime_hours', 5, 2)->nullable();
            $table->json('bonuses')->nullable();
            $table->smallInteger('vacations')->nullable();
            $table->decimal('vacation_compensation', 9, 2)->nullable();
            $table->decimal('monthly_bonus', 9,2)->nullable();
            $table->decimal('fines', 9, 2)->nullable();
            $table->decimal('tax_compensation', 9,2)->nullable();
            $table->decimal('total_usd', 9, 2);
            $table->decimal('currency', 9, 2);
            $table->date('payment_date')->nullable();
            $table->text('comments')->nullable();

            $table->timestamps();

            $table->foreign('calendar_month_id')->on('calendar_months')->references('id')->onDelete('cascade');
            $table->foreign('person_id')->on('people')->references('id')->onDelete('cascade');
            $table->foreign('account_id')->on('accounts')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_payments');
    }
}
