<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WalletTransactionEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("wallet_transaction", function(Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments("id");
            $table->unsignedInteger("amount");
            $table->string("source",250)->nullable();

            $table->string("response_code",30)->nullable();
            $table->string("response_message",300)->nullable();
            $table->string("transaction_reference",500)->nullable();
            $table->string("payment_gateway", 100)->nullable();
            $table->string("card_number",30)->nullable();
            $table->string("expiry",20)->nullable();
            $table->string("cvv",5)->nullable();
            $table->string("card_type",15)->nullable();

            $table->unsignedInteger("hospital_id");
            $table->foreign("hospital_id")->references('id')->on('hospital')->onDelete('cascade');
            
            $table->unsignedInteger("hospital_admin_id");
            $table->foreign("hospital_admin_id")->references('id')->on('hospital_admin')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("wallet_transaction");
    }
}
