<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('calendar_year_id');
            $table->date('date');
            $table->string('name', 10);
            $table->smallInteger('calendar_days')->default(0);
            $table->smallInteger('holidays')->default(0);
            $table->smallInteger('weekends')->default(0);
            $table->timestamps();

            $table->foreign('calendar_year_id')
                ->on('calendar_years')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_months');
    }
}
