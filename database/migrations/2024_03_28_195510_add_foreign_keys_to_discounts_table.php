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
        Schema::table('discounts', function (Blueprint $table) {
            $table->foreign(['access_type_code'])->references(['code'])->on('access_types')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['brand_id'])->references(['id'])->on('brands')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['region_id'])->references(['id'])->on('regions')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropForeign('discounts_access_type_code_foreign');
            $table->dropForeign('discounts_brand_id_foreign');
            $table->dropForeign('discounts_region_id_foreign');
        });
    }
};
