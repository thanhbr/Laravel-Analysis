<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('CUS_ID');
            $table->string('CUSNAME', 50)->nullable();
            $table->string('CUSPHONE', 50)->nullable();
            $table->string('CUSADDRESS', 50)->nullable();
            $table->string('CUSEMAIL', 50)->nullable();
            $table->string('CUSUSERNAME', 50)->nullable();
            $table->string('CUSPASSWORD', 200)->nullable();
            $table->tinyInteger('CUSTYPE')->nullable();
            $table->boolean('IsDeleted')->default(0);
            $table->dateTime('CreatedDate')->useCurrent();
            $table->integer('CreatedBy')->nullable();
            $table->dateTime('UpdatedDate')->nullable();
            $table->integer('UpdatedBy')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
