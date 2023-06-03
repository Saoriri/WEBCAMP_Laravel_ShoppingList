<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePurchaseDateFromCompletedShoppingLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('completed_shopping_lists', function (Blueprint $table) {
        $table->dropColumn('purchase_date');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
    {
    Schema::table('completed_shopping_lists', function (Blueprint $table) {
        $table->date('purchase_date');
    });
    }
}