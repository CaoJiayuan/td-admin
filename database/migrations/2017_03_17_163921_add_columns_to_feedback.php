<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToFeedback extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('feedback', function (Blueprint $table) {
      $table->string('img')->nullable()->comment('图片');
      $table->string('email', 30)->nullable()->comment('email');
      $table->unsignedInteger('user_id')->nullable()->comment('用户id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('feedback', function (Blueprint $table) {
        $table->dropColumn(['img','email','user_id']);
    });
  }
}
