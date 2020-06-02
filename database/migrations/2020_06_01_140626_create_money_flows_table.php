<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class CreateMoneyFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_flows', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->default(Carbon::now());
            $table->unsignedBigInteger('account_from_id');
            $table->float('sum_from');
            $table->unsignedBigInteger('account_to_id');
            $table->float('sum_to');
            $table->float('currency_rate')->nullable();
            $table->float('fee')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('account_from_id')
                ->on('accounts')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('account_to_id')
                ->on('accounts')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_flows');
    }
}
