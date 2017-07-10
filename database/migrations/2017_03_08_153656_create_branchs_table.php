<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('branchs', function (Blueprint $table) {
        $table->increments('id');
        $table->string('branch_id',40)->comment('单位编号');
        $table->string('branch_name',100)->comment('单位名称');
        $table->integer('parent_id')->nullable()->comment('上级单位ID');
        $table->string('branch_internal_code',40)->nullable()->comment('单位内部编号');
        $table->unsignedInteger('status')->default(1)->comment('0-已删除，1-已创建');
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
      Schema::dropIfExists('branchs');
    }
}
