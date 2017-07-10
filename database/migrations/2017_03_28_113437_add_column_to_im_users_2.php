<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToImUsers2 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('im_users', function (Blueprint $table) {
      $table->boolean('online')->default(false)->comment('是否在线');
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
      $table->dropColumn('online');
    });
  }
}
