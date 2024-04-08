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
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedInteger('priority')->default(0);
            $table->boolean('active')->default(false);
            $table->unsignedBigInteger('region_id')->index('discounts_region_id_foreign');
            $table->unsignedBigInteger('brand_id')->index('discounts_brand_id_foreign');
            $table->string('access_type_code', 1)->index('discounts_access_type_code_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};
