<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientToStockLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::table('stock_logs', function (Blueprint $table) {
    //         $table->string('client')->unsigned()->change();
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::table('stock_logs', function (Blueprint $table) {
    //         $table->dropColumn('client')->unsigned()->nullable(false)->change();
    //     });
    // }
}
