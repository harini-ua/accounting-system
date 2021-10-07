<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('plan_date');
            $table->date('real_date')->nullable();
            $table->string('purpose');
            $table->decimal('plan_sum', 15, 2)->nullable();
            $table->decimal('real_sum', 15, 2)->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedInteger('expense_category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')
                ->on('accounts')->references('id')->onDelete('cascade');
            $table->foreign('expense_category_id')
                ->on('expense_categories')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
