<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLongVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('long_vacations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->date('long_vacation_started_at')->nullable();
            $table->string('long_vacation_reason')->nullable();
            $table->boolean('long_vacation_compensation')->default(false);
            $table->decimal('long_vacation_compensation_sum', 9,2)->nullable();
            $table->string('long_vacation_comment')->nullable();
            $table->date('long_vacation_plan_finished_at')->nullable();
            $table->date('long_vacation_finished_at')->nullable();
            $table->timestamps();

            $table->foreign('person_id')
                ->on('people')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('long_vacations');
    }
}
