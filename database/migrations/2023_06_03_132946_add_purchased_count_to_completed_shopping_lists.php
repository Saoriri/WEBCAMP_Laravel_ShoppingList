<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchasedCountToCompletedShoppingLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('completed_shopping_lists', function (Blueprint $table) {
            $table->unsignedInteger('purchased_count')->default(0)->after('user_id')->comment('購入回数');
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