<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToBrokersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('brokers', function (Blueprint $table) {
        $table->integer('admin_id')->comment('后台用户id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('brokers', function (Blueprint $table) {
        $table->dropColumn([
          'admin_id'
        ]);
      });
    }
}
