<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToNotifiationsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('notifiations', function (Blueprint $table) {
        $table->string('resource_name')->nullable()->comment('资源名称');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('notifiations', function (Blueprint $table) {
        $table->dropColumn('resource_name');
      });
    }
}
