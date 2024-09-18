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
        Schema::create('book_category', function (Blueprint $table) {
            $table->bigInteger('book_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            
            $table->foreign('book_id')
                    ->references('id')->on('book');
            $table->foreign('category_id')
                    ->references('id')->on('category');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_category');
    }
};
