<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchasedCountToShoppingLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
    Schema::table('shopping_lists', function (Blueprint $table) {
        $table->unsignedInteger('purchased_count')->default(0)->after('register');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::table('shopping_lists', function (Blueprint $table) {
        $table->dropColumn('purchased_count');
    });
    }
}
