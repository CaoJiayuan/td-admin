<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('complaints', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('comment_id')->comment('评论id');
      $table->unsignedTinyInteger('type')->comment('类型0-资讯,1-专栏');
      $table->unsignedTinyInteger('user_id')->comment('用户id');
      $table->string('content')->comment('内容git pu');
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
    Schema::dropIfExists('complaints');
  }
}
