<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToAdminsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('admins', function (Blueprint $table) {
      $table->string('mobile',20)->unique()->nullable()->comment('手机号');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('admins', function (Blueprint $table) {
      $table->dropColumn('mobile');
    });
  }
}
