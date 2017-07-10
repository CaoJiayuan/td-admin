<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToImUsers3 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('im_users', function (Blueprint $table) {
      $table->string('device_id')->nullable()->comment('设备号');
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
      $table->dropColumn('device_id');
    });
  }
}
