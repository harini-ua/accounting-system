<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('position_id');
            $table->string('department')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('start_date');
            $table->text('skills')->nullable();
            $table->text('certifications')->nullable();
            $table->decimal('available_vacations', 5, 2)->default(15);
            $table->boolean('compensate')->default(false);
            $table->smallInteger('compensated_days')->nullable();
            $table->date('compensated_at')->nullable();
            // Salary
            $table->decimal('salary', 9,2);
            $table->string('currency', 5)->default(\App\Enums\Currency::USD);
            $table->decimal('rate', 4,2);
            $table->string('salary_type', 10)->default(\App\Enums\SalaryType::Fixed40);
            $table->string('contract_type', 15)->default(\App\Enums\PersonContractType::Individual2);
            $table->date('contract_type_changed_at')->nullable();
            // Salary changed
            $table->date('salary_type_changed_at')->nullable();
            $table->date('salary_changed_at')->nullable();
            $table->string('salary_change_reason')->nullable();
            $table->decimal('last_salary', 9,2)->nullable();
            // Additional information
            $table->boolean('growth_plan')->default(false);
            $table->boolean('tech_lead')->default(false);
            $table->decimal('tech_lead_reward', 9,2)->nullable();
            $table->boolean('team_lead')->default(false);
            $table->decimal('team_lead_reward', 9,2)->nullable();
            $table->boolean('bonuses')->default(false);
            $table->smallInteger('bonuses_reward')->nullable();
            $table->unsignedBigInteger('recruiter_id')->nullable();
            // Quit
            $table->date('quited_at')->nullable();
            $table->string('quit_reason')->nullable();
            // Pay data
            $table->string('code')->nullable();
            $table->string('agreement')->nullable();
            $table->string('account_number')->nullable();
            $table->string('recipient_bank')->nullable();
            $table->string('note_salary_pay')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->on('users')->references('id')->onDelete('set null');
            $table->foreign('recruiter_id')->on('users')->references('id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
