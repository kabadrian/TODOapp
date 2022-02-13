<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('to_do_item_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign( ['to_do_item_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_do_item_id')->references('id')->on('to_do_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('to_do_item_user', function (Blueprint $table) {
            //
        });
    }
};
