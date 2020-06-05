<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', static function (Blueprint $table) {
            $table->id();
            $table->string('number', 100);
            $table->string('name', 150);
            $table->unsignedInteger('client_id');
            $table->unsignedBigInteger('contract_id');
            $table->date('date')->default(\Carbon\Carbon::now());
            $table->unsignedInteger('wallet_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('sales_manager_id');
            $table->string('status', 20)
                ->default(\App\Enums\InvoiceStatus::DRAFT);
            $table->date('plan_income_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->on('clients')->references('id')->onDelete('cascade');
            $table->foreign('contract_id')->on('contracts')->references('id')->onDelete('cascade');
            $table->foreign('account_id')->on('accounts')->references('id')->onDelete('cascade');
            $table->foreign('sales_manager_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
