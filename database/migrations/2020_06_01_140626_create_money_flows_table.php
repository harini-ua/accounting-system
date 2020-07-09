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
            $table->decimal('sum_from', 15, 2);
            $table->unsignedBigInteger('account_to_id');
            $table->decimal('sum_to', 15, 2);
            $table->decimal('currency_rate', 15, 2)->nullable();
            $table->decimal('fee', 15, 2)->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
