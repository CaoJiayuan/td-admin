<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToImUsers1 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('im_users', function (Blueprint $table) {
      $table->string('con_id', 64)->nullable()->comment('当前回话id');
      $table->string('nick', 64)->nullable()->comment('用户nickname');
      $table->string('icon_url')->nullable()->comment('用户头像url');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('im_users', function (Blueprint $table) {
      $table->dropColumn('con_id', 'nick', 'icon_url');
    });
  }
}
