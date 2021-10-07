<?php

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
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
            $table->string('number', 100)->nullable();
            $table->string('name', 100);
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('sales_manager_id');
            $table->date('date')->useCurrent();
            $table->string('status', 20)
                ->default(InvoiceStatus::DRAFT);
            $table->string('type', 20)
                ->default(InvoiceType::DEFAULT);
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->date('plan_income_date');
            $table->date('pay_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('contract_id')
                ->on('contracts')->references('id')->onDelete('cascade');
            $table->foreign('account_id')
                ->on('accounts')->references('id')->onDelete('cascade');
            $table->foreign('sales_manager_id')
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
        Schema::dropIfExists('invoices');
    }
}
