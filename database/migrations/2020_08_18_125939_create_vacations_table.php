<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calendar_month_id');
            $table->date('date');
            $table->string('type', 20);
            $table->string('payment_type', 20);
            $table->unsignedBigInteger('person_id');
            $table->smallInteger('days')->default(1);
            $table->timestamps();

            $table->foreign('calendar_month_id')
                ->on('calendar_months')->references('id')->onDelete('cascade');
            $table->foreign('person_id')
                ->on('people')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacations');
    }
}
