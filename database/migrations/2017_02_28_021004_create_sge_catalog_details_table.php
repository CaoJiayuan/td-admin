<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSgeCatalogDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sge_catalogs_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sge_catalog_id')->comment('目录ID');
            $table->string('question',100)->comment('问题');
            $table->text('answer')->comment('答案');
            $table->unsignedTinyInteger('status')->comment('状态(0-已删除,1-可用)');
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
        Schema::dropIfExists('sge_catalogs_details');
    }
}
