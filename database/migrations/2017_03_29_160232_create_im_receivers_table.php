<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImReceiversTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('im_receivers', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('im_message_id')->comment('消息id,对应im_messages');
      $table->unsignedInteger('receiver_id')->comment('消息接受者id,对应im_users');
      $table->index(['im_message_id','receiver_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('im_receivers');
  }
}
