<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePurchasedCountColumnFromCompletedShoppingLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('completed_shopping_lists', function (Blueprint $table) {
            $table->dropColumn('purchased_count');
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
            $table->integer('purchased_count');
        });
    }
}