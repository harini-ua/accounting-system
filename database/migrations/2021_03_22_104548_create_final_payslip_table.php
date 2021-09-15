<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalPayslipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_payslip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->date('last_working_day')->default(\Carbon\Carbon::now());
            $table->integer('working_days');
            $table->integer('worked_days');
            $table->integer('working_hours');
            $table->integer('worked_hours');
            $table->decimal('basic_salary', 9,2);
            $table->decimal('earned', 9,2);
            $table->json('bonuses')->nullable();
            $table->smallInteger('vacations')->nullable();
            $table->decimal('vacation_compensation', 9,2)->nullable();
            $table->decimal('leads', 9,2)->nullable();
            $table->decimal('monthly_bonus', 9,2)->nullable();
            $table->decimal('fines', 9,2)->nullable();
            $table->decimal('tax_compensation', 9,2)->nullable();
            $table->decimal('other_compensation', 9,2)->nullable();
            $table->decimal('total_usd', 9,2);
            $table->decimal('total_uah', 9,2);
            $table->unsignedBigInteger('account_id');
            $table->boolean('paid')->default(0);
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->foreign('person_id')
                ->on('people')->references('id')->onDelete('cascade');
            $table->foreign('account_id')
                ->on('accounts')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_payslip');
    }
}
