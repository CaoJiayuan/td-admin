<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',20)->comment('广告标题');
            $table->string('img',100)->comment('广告图片');
            $table->integer('ad_position_id')->comment('广告位id');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型(0-链接,1-素材,2-专题)');
            $table->string('url',100)->nullable()->comment('广告链接');
            $table->integer('resource_id')->nullable()->comment('素材id');
            $table->unsignedTinyInteger('status')->default(1)->comment('0-已删除,1-可用');
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
        Schema::dropIfExists('ads');
    }
}
