<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->string('title', 100);
            $table->text('description');
            $table->decimal('sum', 15,2);
            $table->decimal('discount', 15,2);
            $table->decimal('total', 15,2);
            $table->string('type', 20);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')->on('invoices')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
