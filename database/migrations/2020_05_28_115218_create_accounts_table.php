<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('account_type_id');
            $table->unsignedBigInteger('wallet_id');
            $table->timestamp('started_at')->nullable()->default(Carbon::now());
            $table->decimal('balance', 15, 2)->default(0.0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_type_id')
                ->on('account_types')->references('id')->onDelete('cascade');
            $table->foreign('wallet_id')
                ->on('wallets')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
