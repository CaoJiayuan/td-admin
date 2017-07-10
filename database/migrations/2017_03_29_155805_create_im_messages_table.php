<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImMessagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('im_messages', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('sender_id')->comment('发送者id,对应im_users');
      $table->tinyInteger('type')->comment('类型');
      $table->text('summary')->comment('摘要');
      $table->text('msg')->comment('消息内容json receiver');
      $table->index('sender_id');

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
    Schema::dropIfExists('im_messages');
  }
}
