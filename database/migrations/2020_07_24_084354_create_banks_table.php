<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('account', 100)->nullable();
            $table->string('iban', 34)->nullable();
            $table->string('swift', 11)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                ->on('clients')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
}
