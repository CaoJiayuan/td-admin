<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('versions', function (Blueprint $table) {
      $table->increments('id');
      $table->text('content')->comment('内容');
      $table->string('version', 15)->comment('版本号');
      $table->string('build', 50)->comment('Build code');
      $table->unsignedTinyInteger('type')->default(0)->comment('更新类型0-更新提醒,1-强制更新');
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
    Schema::dropIfExists('versions');
  }
}
