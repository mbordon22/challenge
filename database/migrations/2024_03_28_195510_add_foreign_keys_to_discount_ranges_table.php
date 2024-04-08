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
        Schema::table('discount_ranges', function (Blueprint $table) {
            $table->foreign(['discount_id'])->references(['id'])->on('discounts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_ranges', function (Blueprint $table) {
            $table->dropForeign('discount_ranges_discount_id_foreign');
        });
    }
};
