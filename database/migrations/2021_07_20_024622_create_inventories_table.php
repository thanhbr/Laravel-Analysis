<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('INV_ID');
            $table->string('INVID', 20)->nullable();
            $table->string('INVNAME', 100)->nullable();
            $table->boolean('IsDeleted')->default(0);
            $table->dateTime('CreatedDate')->useCurrent();
            $table->integer('CreatedBy')->nullable();
            $table->dateTime('UpdatedDate')->nullable();
            $table->integer('UpdatedBy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
