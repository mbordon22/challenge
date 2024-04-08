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
        Schema::create('discount_ranges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('from_days');
            $table->unsignedInteger('to_days');
            $table->double('discount')->nullable();
            $table->string('code', 15)->nullable();
            $table->unsignedBigInteger('discount_id')->index('discount_ranges_discount_id_foreign');
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
        Schema::dropIfExists('discount_ranges');
    }
};
