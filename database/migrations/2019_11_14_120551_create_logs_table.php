<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->date('date');
            $table->string('product');
            $table->integer('quantity');
            $table->float('cost_price');
            $table->float('rate');
            $table->string('supplier');
            $table->string('client');
            $table->float('sub_amount');
            $table->float('discount');
            $table->float('grand_total');
            $table->float('paid_amount');
            $table->float('due_amount');
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
        Schema::dropIfExists('logs');
    }
}
