<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToChatterServices1 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('chatter_services', function (Blueprint $table) {
      $table->timestamp('last_msg_at')->default(\Carbon\Carbon::now())->nullable()->comment('上一条消息发送时间');
      $table->text('last_msg')->nullable()->comment('上一条消息');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('chatter_services', function (Blueprint $table) {
      $table->dropColumn('last_msg_at', 'last_msg');
    });
  }
}
