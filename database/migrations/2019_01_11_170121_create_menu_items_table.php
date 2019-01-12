<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_menus_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('parent_id')->default(0);
            $table->enum('state', array('PUBLISHED', 'TRASH', 'DRAFT'))->default('PUBLISHED');
            $table->string('content');
            $table->string('link');
            $table->string('target_link')->default('_self');
            $table->integer('order')->default(0);
            $table->string('icon')->nullable();
            $table->string('class')->nullable();
            $table->string('title')->nullable();

            $table->foreign('menu_id')->references('id')->on('am_menus');
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
        Schema::dropIfExists('am_menus_items');
    }
}
