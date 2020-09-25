<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', static function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id');
            $table->string('name');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('sales_manager_id');
            $table->string('status', 20)
                ->default(\App\Enums\ContractStatus::OPENED);
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                ->on('clients')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('sales_manager_id')
                ->on('users')
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
        Schema::dropIfExists('contracts');
    }
}
