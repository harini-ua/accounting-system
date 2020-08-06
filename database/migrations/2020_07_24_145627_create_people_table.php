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
            // salary
            $table->decimal('salary', 7,2);
            $table->string('currency', 5)->default(\App\Enums\Currency::USD);
            $table->decimal('rate', 4,2);
            $table->string('salary_type', 10)->default(\App\Enums\SalaryType::Fixed40);
            $table->string('contract_type', 15)->default(\App\Enums\PersonContractType::Individual2);
            $table->date('contract_type_changed_at')->nullable();
            // salary changed
            $table->date('salary_type_changed_at')->nullable();
            $table->date('salary_changed_at')->nullable();
            $table->string('salary_change_reason')->nullable();
            $table->decimal('last_salary', 7,2)->nullable();
            // Additional information
            $table->boolean('growth_plan')->default(false);
            $table->boolean('tech_lead')->default(false);
            $table->boolean('team_lead')->default(false);
            $table->boolean('bonuses')->default(false);
            // Long-term vacation
            $table->date('long_vacation_started_at')->nullable();
            $table->string('long_vacation_reason')->nullable();
            $table->decimal('long_vacation_compensation', 7,2)->nullable();
            $table->string('long_vacation_comment')->nullable();
            $table->date('long_vacation_plan_finished_at')->nullable();
            $table->date('long_vacation_finished_at')->nullable();
            // Quit
            $table->date('quited_at')->nullable();
            $table->string('quit_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->on('users')->references('id')->onDelete('set null');
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
