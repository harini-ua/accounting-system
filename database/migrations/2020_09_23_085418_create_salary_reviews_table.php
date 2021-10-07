<?php

use App\Enums\SalaryReviewType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->date('date');
            $table->string('type')->default(SalaryReviewType::ACTUAL);
            $table->decimal('sum', 15, 2);
            $table->string('reason')->nullable();
            $table->string('comment')->nullable();
            $table->string('prof_growth')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('salary_reviews');
    }
}
