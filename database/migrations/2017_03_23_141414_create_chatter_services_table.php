<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatterServicesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('chatter_services', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('chatter_id')->comment('聊天用户id,客户,关联im_users表');
      $table->unsignedInteger('service_id')->comment('客服id,客户经理,关联im_users表');
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
    Schema::dropIfExists('chatter_services');
  }
}
