<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('CAT_ID');
            $table->integer('PARENT_ID')->nullable();
            $table->string('Name')->nullable();
            $table->integer('DisplayOrder')->nullable();
            $table->boolean('IsPublished')->nullable();
            $table->integer('Depth')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
