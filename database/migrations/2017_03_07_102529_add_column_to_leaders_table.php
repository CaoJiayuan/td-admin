<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToLeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('leaders', function (Blueprint $table) {
        $table->unsignedTinyInteger('status')->default(1)->comment('状态');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('leaders', function (Blueprint $table) {
        $table->dropColumn('status');
      });
    }
}
