<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToAdPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_positions',function($table){
            $table->string('size',20)->comment('图片尺寸');
            $table->unsignedTinyInteger('code')->comment('广告位代码');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_positions',function($table){
            $table->dropColumn('size');
            $table->dropColumn('code');
        });
    }
}
