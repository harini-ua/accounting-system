<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('name');
            $table->string('subject');
            $table->decimal('cost', 15,2)->nullable();
            $table->string('availability')->nullable();
            $table->decimal('sum_award', 15,2)->nullable();
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
        Schema::dropIfExists('certifications');
    }
}
