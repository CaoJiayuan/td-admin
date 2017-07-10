<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSgeCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SgeCatalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->comment('目录名称');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态(0-已删除,1-可用)');
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
        Schema::dropIfExists('SgeCatalogs');
    }
}
