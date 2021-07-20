<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('COM_ID');
            $table->integer('CUS_ID')->unsigned();
            $table->integer('PRO_ID')->unsigned();
            $table->string('COMTITLE', 50)->nullable();
            $table->string('COMDESC', 200)->nullable();
            $table->dateTime('COMDATE')->useCurrent();
            $table->boolean('IsDeleted')->default(0);
            $table->dateTime('CreatedDate')->useCurrent();
            $table->integer('CreatedBy')->nullable();
            $table->dateTime('UpdatedDate')->nullable();
            $table->integer('UpdatedBy')->nullable();

            $table->foreign('CUS_ID')
                ->references('CUS_ID')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreign('PRO_ID')
                ->references('PRO_ID')
                ->on('products')
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
        Schema::dropIfExists('comments');
    }
}
