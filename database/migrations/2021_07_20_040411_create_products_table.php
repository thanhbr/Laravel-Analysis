<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('PRO_ID');
            $table->integer('BRA_ID')->unsigned();
            $table->string('PRONAME', 100)->nullable();
            $table->string('PROIMAGE', 200)->nullable();
            $table->text('PRODESCRIPTION')->nullable();
            $table->tinyInteger('PROSTATUS')->nullable();
            $table->integer('PROMODEL')->nullable();
            $table->tinyInteger('PROTYPE')->nullable();
            $table->string('PROSIZE', 100)->nullable();
            $table->integer('PROWEIGHT')->nullable();
            $table->boolean('IsDeleted')->default(0);
            $table->dateTime('CreatedDate')->useCurrent();
            $table->integer('CreatedBy')->nullable();
            $table->dateTime('UpdatedDate')->nullable();
            $table->integer('UpdatedBy')->nullable();

            $table->foreign('BRA_ID')
                ->references('BRA_ID')
                ->on('brands')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
