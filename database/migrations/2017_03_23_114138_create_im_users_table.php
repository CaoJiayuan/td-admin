<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('im_users', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('user_id')->index()->nullable()->comment('用户id或客服id');
      $table->unsignedInteger('service_id')->nullable()->comment('用户的当前客服id');
      $table->string('im_id', 64)->comment('im ID');
      $table->string('im_password', 64)->comment('im密码');
      $table->unsignedTinyInteger('type')->default(0)->comment('类型(0-用户,1-客服)');
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
    Schema::dropIfExists('im_users');
  }
}
